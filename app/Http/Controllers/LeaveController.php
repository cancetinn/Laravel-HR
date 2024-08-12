<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\AnnualLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function showLeaveRequests()
    {
        $user = Auth::user();
        $leaveRequests = $user->leaveRequests()->get();

        $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();
        $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
        $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
        $remainingLeaves = $totalLeaves - $usedLeaves;

        $pendingRequest = $user->leaveRequests()->where('status', 'pending')->exists();

        return view('leaves.requests', compact('leaveRequests', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'pendingRequest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestLeave(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $user = Auth::user();

        $pendingRequest = $user->leaveRequests()->where('status', 'pending')->exists();
        if ($pendingRequest) {
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLeaveRequest(Request $request, $requestId)
    {
        $leaveRequest = LeaveRequest::findOrFail($requestId);

        if ($request->input('action') === 'approve') {
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

        } elseif ($request->input('action') === 'reject') {
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();
        }

        return back()->with('success', 'İzin talebi güncellendi.');
    }

    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return int
     */
    private function calculateWeekdays(Carbon $startDate, Carbon $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $weekdays = 0;

        foreach ($period as $date) {
            if (!$date->isWeekend()) {
                $weekdays++;
            }
        }

        return $weekdays;
    }

    public function cancelLeaveRequest($requestId)
    {
        $leaveRequest = LeaveRequest::findOrFail($requestId);

        if ($leaveRequest->status === 'approved' || $leaveRequest->status === 'pending') {
            $annualLeave = AnnualLeave::where('user_id', $leaveRequest->user_id)
                                    ->where('year', now()->year)
                                    ->first();

            if ($annualLeave) {
                // Kullanılan izin günlerini geri yükle
                $annualLeave->used_leaves = max(0, $annualLeave->used_leaves - $leaveRequest->days_used);
                $annualLeave->save();
            }

            // İzin talebinin durumunu iptal olarak güncelle
            $leaveRequest->status = 'canceled';
            $leaveRequest->save();

            return back()->with('success', 'İzin talebi iptal edildi ve izin günleri geri yüklendi.');
        }

        return back()->with('error', 'Bu izin talebi zaten iptal edilmiş veya reddedilmiş.');
    }
}
