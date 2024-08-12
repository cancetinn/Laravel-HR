<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        return view('leaves.requests', compact('leaveRequests', 'totalLeaves', 'usedLeaves', 'remainingLeaves'));
    }

    /**
     * İzin talebi oluşturur.
     *
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
        
        // Tarihleri Carbon nesnelerine dönüştür
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // İzin günlerini hesapla
        $leaveDays = $startDate->diffInDays($endDate) + 1;

        // Kullanıcının yeterli izin günü olup olmadığını kontrol et
        $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();

        if ($annualLeave && $annualLeave->total_leaves - $annualLeave->used_leaves >= $leaveDays) {
            LeaveRequest::create([
                'user_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
            ]);

            return back()->with('success', 'İzin talebi gönderildi.');
        }

        return back()->with('error', 'Yeterli izin gününüz yok.');
    }
}
