<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function members(Request $request)
    {
        $status = $request->query('status');
        $query = \App\Models\Anggota::query();
        if ($status) {
            $query->where('status', $status);
        }
        $daftarAnggota = $query->get();
        return view('reports.members', compact('daftarAnggota', 'status'));
    }

    public function savings(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $query = \App\Models\Saving::with('anggota');
        
        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }
        
        $savings = $query->get();
        $totalDeposit = $savings->where('transaction_type', 'deposit')->sum('amount');
        $totalWithdrawal = $savings->where('transaction_type', 'withdrawal')->sum('amount');
        
        return view('reports.savings', compact('savings', 'totalDeposit', 'totalWithdrawal', 'startDate', 'endDate'));
    }

    public function loans(Request $request)
    {
        // Simple report of loans approved in a period or all time
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $query = \App\Models\Loan::with('anggota');
        
        if ($startDate && $endDate) {
            $query->whereBetween('application_date', [$startDate, $endDate]);
        }
        
        $loans = $query->get();
        return view('reports.loans', compact('loans', 'startDate', 'endDate'));
    }

    public function installments(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $query = \App\Models\Installment::with('loan.anggota');
        
        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }
        
        $installments = $query->get();
        $totalPaid = $installments->sum('amount_paid');
        $totalInterest = $installments->sum('interest_paid');
        
        return view('reports.installments', compact('installments', 'totalPaid', 'totalInterest', 'startDate', 'endDate'));
    }

    public function financial()
    {
        // Simple Financial Overview
        $totalSavings = \App\Models\Saving::where('transaction_type', 'deposit')->sum('amount') 
                      - \App\Models\Saving::where('transaction_type', 'withdrawal')->sum('amount');
                      
        $totalLoansDisbursed = \App\Models\Loan::where('status', 'approved')->orWhere('status', 'paid')->sum('amount');
        
        // Outstanding is simpler to calc from active loans? Or easier: Total Disbursed - Total Principal Repaid
        $totalPrincipalRepaid = \App\Models\Installment::sum('principal_paid');
        $outstandingLoans = $totalLoansDisbursed - $totalPrincipalRepaid;
        
        $totalRevenueInterest = \App\Models\Installment::sum('interest_paid');
        
        return view('reports.financial', compact('totalSavings', 'totalLoansDisbursed', 'outstandingLoans', 'totalRevenueInterest'));
    }
}
