<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $query = \App\Models\Loan::with('member');

        if (auth()->user()->role === 'member') {
            if (auth()->user()->member) {
                $query->where('member_id', auth()->user()->member->id);
            } else {
                $query->where('id', 0);
            }
        }

        $loans = $query->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = \App\Models\Member::where('status', 'active')->get();
        return view('loans.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'application_date' => 'required|date',
        ]);

        $validated['status'] = 'pending';

        \App\Models\Loan::create($validated);

        return redirect()->route('loans.index')->with('success', 'Loan application submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = \App\Models\Loan::with(['member', 'installments', 'approver'])->findOrFail($id);
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Typically loans are not edited after submission unless pending
        $loan = \App\Models\Loan::findOrFail($id);
        if ($loan->status !== 'pending') {
             return back()->with('error', 'Only pending loans can be edited.');
        }
        $members = \App\Models\Member::where('status', 'active')->get();
        return view('loans.edit', compact('loan', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loan = \App\Models\Loan::findOrFail($id);
        if ($loan->status !== 'pending') {
             return back()->with('error', 'Only pending loans can be edited.');
        }

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'application_date' => 'required|date',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = \App\Models\Loan::findOrFail($id);
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }

    public function approve(Request $request, string $id)
    {
        // Auth check or middleware should handle role, here double check
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $loan = \App\Models\Loan::findOrFail($id);
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Loan is not pending approval.');
        }

        $loan->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approval_date' => now(),
        ]);

        // Logic to disburse funds could go here (e.g., create a Savings withdrawal or just record it)
        // For now, we assume funds are disbursed manually or recorded separately.

        return back()->with('success', 'Loan approved successfully.');
    }

    public function reject(Request $request, string $id)
    {
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $loan = \App\Models\Loan::findOrFail($id);
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Loan is not pending approval.');
        }

        $loan->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
            'approval_date' => now(),
        ]);

        return back()->with('success', 'Loan rejected.');
    }
}
