<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = \App\Models\Saving::with('member');
        
        if (auth()->user()->role === 'member') {
            if (auth()->user()->member) {
                $query->where('member_id', auth()->user()->member->id);
            } else {
                $query->where('id', 0); // Show nothing if not linked
            }
        }

        $savings = $query->latest()->paginate(10);
        return view('savings.index', compact('savings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'member' && auth()->user()->member) {
            $members = \App\Models\Member::where('id', auth()->user()->member->id)->get();
        } else {
            $members = \App\Models\Member::where('status', 'active')->get();
        }
        return view('savings.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:pokok,wajib,sukarela',
            'transaction_type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ];

        if (auth()->user()->role === 'member') {
             // For members, only deposits need proof? Or withdrawals too? 
             // Typically withdrawals are requests. Let's assume deposits need proof.
             // But for now, let's enforce proof for 'deposit' if member.
             if ($request->input('transaction_type') === 'deposit') {
                 $rules['proof_file'] = 'required|file|mimes:jpeg,png,pdf|max:2048';
             }
        } else {
            $rules['proof_file'] = 'nullable|file|mimes:jpeg,png,pdf|max:2048';
        }

        $validated = $request->validate($rules);

        // Check balance for withdrawal
        if ($validated['transaction_type'] === 'withdrawal') {
            $currentBalance = \App\Models\Saving::where('member_id', $validated['member_id'])
                ->where('type', $validated['type'])
                ->where('transaction_type', 'deposit')
                ->where('status', 'approved') // Only approved deposits count
                ->sum('amount') 
                - \App\Models\Saving::where('member_id', $validated['member_id'])
                ->where('type', $validated['type'])
                ->where('transaction_type', 'withdrawal')
                ->where('status', 'approved') // Only approved withdrawals count
                ->sum('amount');
            
            if ($validated['amount'] > $currentBalance) {
                return back()->withErrors(['amount' => 'Insufficient active balance for withdrawal.']);
            }
        }

        // Status Handling
        if (auth()->user()->role === 'member') {
            $validated['status'] = 'pending';
        } else {
            $validated['status'] = 'approved';
        }

        // File Upload
        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('proofs', 'public');
            $validated['proof_file'] = $path;
        }

        \App\Models\Saving::create($validated);

        $msg = auth()->user()->role === 'member' 
            ? 'Transaction submitted. Please wait for admin verification.' 
            : 'Transaction recorded successfully.';

        return redirect()->route('savings.index')->with('success', $msg);
    }

    public function approve(Request $request, string $id)
    {
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $saving = \App\Models\Saving::findOrFail($id);
        if ($saving->status !== 'pending') {
             return back()->with('error', 'Transaction is not pending.');
        }

        // For withdrawals, check balance again at approval time
        if ($saving->transaction_type === 'withdrawal') {
             $currentBalance = \App\Models\Saving::where('member_id', $saving->member_id)
                ->where('type', $saving->type)
                ->where('transaction_type', 'deposit')
                ->where('status', 'approved')
                ->sum('amount') 
                - \App\Models\Saving::where('member_id', $saving->member_id)
                ->where('type', $saving->type)
                ->where('transaction_type', 'withdrawal')
                ->where('status', 'approved')
                ->sum('amount');
            
             if ($saving->amount > $currentBalance) {
                 // Auto reject if insufficient funds now
                 $saving->update(['status' => 'rejected']);
                 return back()->with('error', 'Insufficient balance. Transaction rejected.');
             }
        }

        $saving->update(['status' => 'approved']);

        return back()->with('success', 'Transaction approved.');
    }

    public function reject(Request $request, string $id)
    {
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $saving = \App\Models\Saving::findOrFail($id);
        $saving->update(['status' => 'rejected']);

        return back()->with('success', 'Transaction rejected.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $saving = \App\Models\Saving::with('member')->findOrFail($id);
        
        // Authorization check for members
        if (auth()->user()->role === 'member' && auth()->user()->member->id !== $saving->member_id) {
            abort(403);
        }

        return view('savings.show', compact('saving'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $saving = \App\Models\Saving::findOrFail($id);
         $saving->delete();
         return redirect()->route('savings.index')->with('success', 'Transaction deleted successfully.');
    }
}
