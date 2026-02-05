<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index()
    {
        $query = \App\Models\Installment::with('loan.member');

        if (auth()->user()->role === 'member') {
            if (auth()->user()->member) {
                $query->whereHas('loan', function($q) {
                    $q->where('member_id', auth()->user()->member->id);
                });
            } else {
                $query->where('id', 0);
            }
        }

        $installments = $query->latest()->paginate(10);
        return view('installments.index', compact('installments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $loan_id = $request->query('loan_id');
        $loan = null;
        if ($loan_id) {
            $loan = \App\Models\Loan::with('member')->find($loan_id);
             // Security check for pre-selected loan
            if (auth()->user()->role === 'member' && auth()->user()->member) {
                if (!$loan || $loan->member_id !== auth()->user()->member->id) {
                    abort(403, 'Unauthorized loan access');
                }
            }
        }
        
        $query = \App\Models\Loan::where('status', 'approved')->with('member');
        if (auth()->user()->role === 'member' && auth()->user()->member) {
             $query->where('member_id', auth()->user()->member->id);
        }
        $loans = $query->get();
        
        return view('installments.create', compact('loan', 'loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'loan_id' => 'required|exists:loans,id',
            'payment_date' => 'required|date',
            'amount_paid' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ];

        if (auth()->user()->role === 'member') {
            $rules['proof_file'] = 'required|file|mimes:jpeg,png,pdf|max:2048';
        } else {
             $rules['proof_file'] = 'nullable|file|mimes:jpeg,png,pdf|max:2048';
        }

        $validated = $request->validate($rules);

        $loan = \App\Models\Loan::find($validated['loan_id']);
        
         // Total Expected Repayment
        $totalPrincipal = $loan->amount;
        $totalInterest = $totalPrincipal * ($loan->interest_rate / 100);
        $totalDue = $totalPrincipal + $totalInterest;
        $interestRatio = $totalDue > 0 ? ($totalInterest / $totalDue) : 0;
        
        $validated['interest_paid'] = $validated['amount_paid'] * $interestRatio;
        $validated['principal_paid'] = $validated['amount_paid'] - $validated['interest_paid'];

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

        $installment = \App\Models\Installment::create($validated);

        // Update Loan Status ONLY if approved
        if ($validated['status'] === 'approved') {
             $totalPaid = $loan->installments()->where('status', 'approved')->sum('amount_paid');
             if ($totalPaid >= ($totalDue - 100)) { 
                 $loan->update(['status' => 'paid']);
             }
        }

        $msg = auth()->user()->role === 'member' 
            ? 'Payment recorded. Please wait for admin verification.' 
            : 'Payment recorded successfully.';

        return redirect()->route('installments.index')->with('success', $msg);
    }

    public function approve(Request $request, string $id)
    {
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $installment = \App\Models\Installment::findOrFail($id);
        if ($installment->status !== 'pending') {
             return back()->with('error', 'Payment is not pending.');
        }

        $installment->update(['status' => 'approved']);

        // Check Loan Status
        $loan = $installment->loan;
        $totalPrincipal = $loan->amount;
        $totalInterest = $totalPrincipal * ($loan->interest_rate / 100);
        $totalDue = $totalPrincipal + $totalInterest;
        
        $totalPaid = $loan->installments()->where('status', 'approved')->sum('amount_paid');
             
        if ($totalPaid >= ($totalDue - 100)) { 
             $loan->update(['status' => 'paid']);
        }

        return back()->with('success', 'Payment approved.');
    }

    public function reject(Request $request, string $id)
    {
        if (!in_array($request->user()->role, ['admin', 'manager'])) {
            abort(403);
        }

        $installment = \App\Models\Installment::findOrFail($id);
        $installment->update(['status' => 'rejected']);

        return back()->with('success', 'Payment rejected.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $installment = \App\Models\Installment::with('loan.member')->findOrFail($id);
         
         // Auth check
         if (auth()->user()->role === 'member') {
             if (auth()->user()->member->id !== $installment->loan->member_id) {
                 abort(403);
             }
         }

         return view('installments.show', compact('installment'));
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
        $installment = \App\Models\Installment::findOrFail($id);
        $installment->delete();
        return back()->with('success', 'Installment deleted.');
    }
}
