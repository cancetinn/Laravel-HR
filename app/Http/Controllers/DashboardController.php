<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now();

        \App\Models\ShortLeave::where('status', 'approved')
        ->where(function($query) use ($now) {
            $query->where('date', '<', $now->format('Y-m-d'))
                ->orWhere(function($query) use ($now) {
                    $query->where('date', '=', $now->format('Y-m-d'))
                            ->where('end_time', '<=', $now->format('H:i:s'));
                });
        })->update(['status' => 'expire']);

        \App\Models\LeaveRequest::where('status', 'approved')
            ->where('end_date', '<', $now->format('Y-m-d'))
            ->update(['status' => 'expire']);

        $activeShortLeaves = \App\Models\ShortLeave::where('status', 'approved')->get();
        
        $activeAnnualLeaves = \App\Models\LeaveRequest::where('status', 'approved')->get();

        return view('dashboard', compact('activeShortLeaves', 'activeAnnualLeaves'));
    }

    public function getSessionData()
    {
        $sessions = DB::table('sessions')->get();

        return response()->json($sessions);
    }
}


