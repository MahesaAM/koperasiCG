<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'member') {
            $member = $user->member;
            if (!$member) {
                 return view('dashboard', [
                    'totalMembers' => 0,
                    'totalSavings' => 0,
                    'activeLoans' => 0,
                    'warning' => 'Your account is not linked to a member profile.',
                ]);
            }

            $savings = \App\Models\Saving::where('member_id', $member->id)->get();
            $totalMembers = 1; 
            $totalSavings = $savings->where('transaction_type', 'deposit')->sum('amount') - $savings->where('transaction_type', 'withdrawal')->sum('amount');
            $activeLoans = \App\Models\Loan::where('member_id', $member->id)->whereIn('status', ['pending', 'approved'])->count();

             return view('dashboard', compact('totalMembers', 'totalSavings', 'activeLoans'));
        }

        $totalMembers = \App\Models\Member::count();
        $totalSavings = \App\Models\Saving::where('transaction_type', 'deposit')->sum('amount') - \App\Models\Saving::where('transaction_type', 'withdrawal')->sum('amount');
        $activeLoans = \App\Models\Loan::where('status', 'approved')->count();

        return view('dashboard', compact('totalMembers', 'totalSavings', 'activeLoans'));
    }
}
