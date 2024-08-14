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
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currentUser = auth()->user();
    
        if ($currentUser->role == 1) {
            // Admin tüm kullanıcıları görür
            $users = User::with(['annualLeaves' => function ($query) {
                $query->where('year', now()->year);
            }, 'leaveRequests' => function ($query) {
                $query->orderBy('end_date', 'desc');
            }])->get();
        } elseif ($currentUser->role == 2) {
            // Grafik Tasarım departmanındaki kullanıcılar sadece Grafik Tasarım departmanını görür
            $users = User::where('department', 1)
                ->with(['annualLeaves' => function ($query) {
                    $query->where('year', now()->year);
                }, 'leaveRequests' => function ($query) {
                    $query->orderBy('end_date', 'desc');
                }])->get();
        } elseif ($currentUser->role == 3) {
            // İçerik departmanındaki kullanıcılar sadece İçerik departmanını görür
            $users = User::where('department', 3)
                ->with(['annualLeaves' => function ($query) {
                    $query->where('year', now()->year);
                }, 'leaveRequests' => function ($query) {
                    $query->orderBy('end_date', 'desc');
                }])->get();
        } else {
            $users = collect();
        }
    
        return view('admin.leaves.index', compact('users'));
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
     * @param int $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function showUserLeaveHistory($userId)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($userId);
    
        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            // Admin ise veya departman aynı ise izin geçmişini göster
            $user = User::with('leaveRequests')->findOrFail($userId);
            return view('admin.leaves.history', compact('user'));
        } else {
            // Yetkisi yoksa 403 döndür
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }
    }             

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAnnualLeave(Request $request, $userId)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($userId);
    
        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            // Admin veya aynı departmandaki kullanıcı yıllık izni güncelleyebilir
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
                $annualLeave = AnnualLeave::create([
                    'user_id' => $user->id,
                    'year' => now()->year,
                    'total_leaves' => $request->input('total_leaves'),
                    'used_leaves' => 0,
                ]);
            }
    
            return redirect()->route('admin.leaves.edit', $user->id)->with('success', 'Yıllık izin güncellendi.');
        } else {
            // Yetkisi olmayan kullanıcılar güncelleme yapamaz
            abort(403, 'Bu işlemi gerçekleştirme yetkiniz yok.');
        }
    }         

    /**
     * @param int $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($userId)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($userId);
    
        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            $annualLeave = $user->annualLeaves->where('year', now()->year)->first();
            $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
            $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
            $remainingLeaves = $totalLeaves - $usedLeaves;
    
            $logs = AnnualLeaveLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    
            return view('admin.leaves.edit', compact('user', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'logs'));
        } else {
            // Yetkisi olmayan kullanıcılar düzenleme yapamaz
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }
    }           

    /**
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function calculateWeekdays($startDate, $endDate)
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
}
