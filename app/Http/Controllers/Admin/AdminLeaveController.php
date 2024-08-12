<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\AnnualLeave;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AnnualLeaveLog;
use Illuminate\Support\Facades\Auth;

class AdminLeaveController extends Controller
{
    /**
     * Kullanıcıların yıllık izin durumlarını ve taleplerini listeler.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::with('annualLeaves', 'leaveRequests')->get();

        return view('admin.leaves.index', compact('users'));
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
            $leaveRequest->save();

            // Kullanıcının yıllık izin güncellemelerini yap
            $annualLeave = AnnualLeave::where('user_id', $leaveRequest->user_id)
                                      ->where('year', now()->year)
                                      ->first();

            if ($annualLeave) {
                $leaveDays = Carbon::parse($leaveRequest->start_date)
                                   ->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1;
                
                $annualLeave->used_leaves += $leaveDays;
                $annualLeave->save();
            }

        } elseif ($request->input('action') === 'reject') {
            // İzin talebini reddet
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();
        }

        return back()->with('success', 'İzin talebi güncellendi.');
    }

    /**
     * Kullanıcının yıllık izin geçmişini görüntüler.
     *
     * @param int $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function showUserLeaveHistory($userId)
    {
        $user = User::with('leaveRequests')->findOrFail($userId);
        return view('admin.leaves.history', compact('user'));
    }

    /**
     * Yıllık izin güncellemelerini yönetir.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAnnualLeave(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Kullanıcının mevcut yıllık izni var mı kontrol et
        $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();

        if ($annualLeave) {
            $previousTotalLeaves = $annualLeave->total_leaves;
            $annualLeave->total_leaves = $request->input('total_leaves');
            $annualLeave->save();

            // Log kaydı ekle
            AnnualLeaveLog::create([
                'user_id' => $user->id,
                'previous_total_leaves' => $previousTotalLeaves,
                'new_total_leaves' => $annualLeave->total_leaves,
                'updated_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            ]);
        } else {
            // Yıllık izin kaydı yoksa yeni kayıt oluştur
            AnnualLeave::create([
                'user_id' => $user->id,
                'year' => now()->year,
                'total_leaves' => $request->input('total_leaves'),
                'used_leaves' => 0, // Varsayılan olarak kullanılmamış izin
            ]);
        }

        return redirect()->route('admin.leaves.edit', $user->id)->with('success', 'Yıllık izin güncellendi.');
    }

    /**
     * Kullanıcı bilgilerini ve izin geçmişini gösterir.
     *
     * @param int $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($userId)
    {
        $user = User::with('leaveRequests')->findOrFail($userId);

        // Kullanıcının yıllık izin durumu
        $annualLeave = $user->annualLeaves->where('year', now()->year)->first();
        $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
        $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
        $remainingLeaves = $totalLeaves - $usedLeaves;

        // Logları al
        $logs = AnnualLeaveLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('admin.leaves.edit', compact('user', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'logs'));
    }
}
