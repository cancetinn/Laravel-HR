<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersLeaveExport implements FromView
{
    public function view(): View
    {
        $users = User::with(['annualLeaves' => function ($query) {
            $query->where('year', now()->year);
        }, 'leaveRequests' => function ($query) {
            $query->where('status', 'approved')->orderBy('end_date', 'desc');
        }])->get();

        return view('admin.leaves.excel', compact('users'));
    }
}
