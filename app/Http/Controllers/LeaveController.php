<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveController extends Controller
{
    /**
     * Yıllık izin durumunu, izin geçmişini ve izin talep formunu gösterir.
     *
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

        // Kullanıcının pending durumda izin talebi olup olmadığını kontrol et
        $pendingRequest = $user->leaveRequests()->where('status', 'pending')->exists();

        return view('leaves.requests', compact('leaveRequests', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'pendingRequest'));
    }

    /**
     * İzin talebini onaylar veya reddeder.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLeaveRequest(Request $request, $requestId)
    {
        $leaveRequest = LeaveRequest::findOrFail($requestId);

        if ($request->input('action') === 'approve') {
            // İzin talebini onayla
            $leaveRequest->status = 'approved';

            // Kullanıcının yıllık izin güncellemelerini yap
            $annualLeave = AnnualLeave::where('user_id', $leaveRequest->user_id)
                                    ->where('year', now()->year)
                                    ->first();

            if ($annualLeave) {
                // Hafta içi günleri hesapla
                $leaveDays = $this->calculateWeekdays($leaveRequest->start_date, $leaveRequest->end_date);

                $annualLeave->used_leaves += $leaveDays;
                $annualLeave->save();
            }

            $leaveRequest->days_used = $leaveDays; // Burada hesaplanan gün sayısını kaydediyoruz.
            $leaveRequest->save();

        } elseif ($request->input('action') === 'reject') {
            // İzin talebini reddet
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();
        }

        return back()->with('success', 'İzin talebi güncellendi.');
    }

    /**
     * Hafta içi günleri hesaplar.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return int
     */
    private function calculateWeekdays(Carbon $startDate, Carbon $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $weekdays = 0;

        foreach ($period as $date) {
            // Cumartesi (6) ve Pazar (7) günlerini atla
            if (!$date->isWeekend()) {
                $weekdays++;
            }
        }

        return $weekdays;
    }
}
