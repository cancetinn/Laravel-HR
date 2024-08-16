<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\AnnualLeave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\AnnualLeaveLog;
use Illuminate\Support\Facades\Auth;

class AdminLeaveController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $usersQuery = User::with(['annualLeaves' => function ($query) {
            $query->where('year', now()->year);
        }, 'leaveRequests' => function ($query) {
            $query->orderBy('end_date', 'desc');
        }]);

        if ($currentUser->role == 1) {
            $users = $usersQuery->get();
        } elseif ($currentUser->role == 2) {
            $users = $usersQuery->where('department', 1)->get(); // Grafik Tasarım departmanı (1)
        } elseif ($currentUser->role == 3) {
            $users = $usersQuery->where('department', 3)->get(); // İçerik departmanı (3)
        } else {
            $users = collect();
        }

        return view('admin.leaves.index', compact('users'));
    }

    public function requestLeave(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        if ($user->leaveRequests()->where('status', 'pending')->exists()) {
            return back()->with('error', 'Zaten bekleyen bir izin talebiniz var.');
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $leaveDays = $this->calculateWeekdays($startDate, $endDate);

        $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();

        if ($annualLeave && $annualLeave->total_leaves - $annualLeave->used_leaves >= $leaveDays) {
            LeaveRequest::create([
                'user_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
                'days_used' => $leaveDays,
            ]);

            return back()->with('success', 'İzin talebi gönderildi.');
        }

        return back()->with('error', 'Yeterli izin gününüz yok.');
    }

    public function updateLeaveRequest(Request $request, $requestId)
    {
        $leaveRequest = LeaveRequest::findOrFail($requestId);
        $action = $request->input('action');

        if ($action === 'approve') {
            $leaveRequest->status = 'approved';

            $annualLeave = AnnualLeave::where('user_id', $leaveRequest->user_id)
                                      ->where('year', now()->year)
                                      ->first();

            if ($annualLeave) {
                $leaveDays = $this->calculateWeekdays($leaveRequest->start_date, $leaveRequest->end_date);
                $annualLeave->used_leaves += $leaveDays;
                $annualLeave->save();
            }

            $leaveRequest->days_used = $leaveDays;
            $leaveRequest->save();
        } elseif ($action === 'reject') {
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();
        }

        return back()->with('success', 'İzin talebi güncellendi.');
    }

    public function showUserLeaveHistory($userId)
    {
        $currentUser = Auth::user();
        $user = User::with('leaveRequests')->findOrFail($userId);

        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            return view('admin.leaves.history', compact('user'));
        }

        abort(403, 'Bu sayfaya erişim yetkiniz yok.');
    }

    public function updateAnnualLeave(Request $request, $userId)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($userId);

        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();
    
            if ($annualLeave) {
                $previousTotalLeaves = $annualLeave->total_leaves;
                $annualLeave->total_leaves = $request->input('total_leaves');
                $annualLeave->used_leaves = min($annualLeave->used_leaves, $annualLeave->total_leaves);
                $annualLeave->save();
    
                AnnualLeaveLog::create([
                    'user_id' => $user->id,
                    'previous_total_leaves' => $previousTotalLeaves,
                    'new_total_leaves' => $annualLeave->total_leaves,
                    'updated_by' => $currentUser->first_name . ' ' . $currentUser->last_name,
                ]);
            } else {
                AnnualLeave::create([
                    'user_id' => $user->id,
                    'year' => now()->year,
                    'total_leaves' => $request->input('total_leaves'),
                    'used_leaves' => 0,
                ]);
            }
    
            return redirect()->route('admin.leaves.edit', $user->id)->with('success', 'Yıllık izin güncellendi.');
        }

        abort(403, 'Bu işlemi gerçekleştirme yetkiniz yok.');
    }

    public function edit($userId)
    {
        $currentUser = Auth::user();
        $user = User::with(['annualLeaves' => function ($query) {
            $query->where('year', now()->year);
        }])->findOrFail($userId);

        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            $annualLeave = $user->annualLeaves->first();
            $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
            $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
            $remainingLeaves = $totalLeaves - $usedLeaves;

            $logs = AnnualLeaveLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

            return view('admin.leaves.edit', compact('user', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'logs'));
        }

        abort(403, 'Bu sayfaya erişim yetkiniz yok.');
    }

    public function calculateWeekdays($startDate, $endDate)
    {
        return CarbonPeriod::create($startDate, $endDate)
            ->filter(fn($date) => !$date->isWeekend())
            ->count();
    }
}