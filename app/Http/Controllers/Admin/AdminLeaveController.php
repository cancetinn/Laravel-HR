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
     * Kullanıcıların yıllık izin durumlarını listeler.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Tüm kullanıcıları yükleyin
        $users = User::with(['annualLeaves' => function ($query) {
            $query->where('year', now()->year);
        }, 'leaveRequests' => function ($query) {
            $query->orderBy('end_date', 'desc');
        }])->get();

        return view('admin.leaves.index', compact('users'));
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

        // Eğer kullanıcının pending durumda izin talebi varsa yeni talep gönderemez
        $pendingRequest = $user->leaveRequests()->where('status', 'pending')->exists();
        if ($pendingRequest) {
            return back()->with('error', 'Zaten bekleyen bir izin talebiniz var.');
        }

        // Tarihleri Carbon nesnelerine dönüştür
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Hafta içi günleri hesapla
        $leaveDays = $this->calculateWeekdays($startDate, $endDate);

        // Kullanıcının yeterli izin günü olup olmadığını kontrol et
        $annualLeave = $user->annualLeaves()->where('year', now()->year)->first();

        if ($annualLeave && $annualLeave->total_leaves - $annualLeave->used_leaves >= $leaveDays) {
            LeaveRequest::create([
                'user_id' => $user->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending',
                'days_used' => $leaveDays, // Gün sayısını burada kaydediyoruz.
            ]);

            return back()->with('success', 'İzin talebi gönderildi.');
        }

        return back()->with('error', 'Yeterli izin gününüz yok.');
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

            $leaveRequest->days_used = $leaveDays; // Gün sayısını burada kaydediyoruz.
            $leaveRequest->save();

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
            $annualLeave->used_leaves = min($annualLeave->used_leaves, $annualLeave->total_leaves);
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
            $annualLeave = AnnualLeave::create([
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

        // Kullanıcıyı ve diğer bilgileri görünüm dosyasına gönder
        return view('admin.leaves.edit', compact('user', 'totalLeaves', 'usedLeaves', 'remainingLeaves', 'logs'));
    }

    /**
     * Hafta içi günleri hesaplar.
     *
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function calculateWeekdays($startDate, $endDate)
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
