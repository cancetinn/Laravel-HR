<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserLeaveHistoryExport implements FromView
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function view(): View
    {
        $leaveRequests = LeaveRequest::where('user_id', $this->userId)->get();

        return view('admin.leaves.history_excel', compact('leaveRequests'));
    }
}
