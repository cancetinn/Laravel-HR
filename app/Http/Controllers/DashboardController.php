<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $now = Carbon::now();

        // Kısa izinler için bitiş saatini ve tarihi kontrol et ve süresi dolanları "izin bitti" olarak güncelle
        $user->shortLeaves()->where('status', 'approved')
        ->where(function($query) use ($now) {
            $query->where('date', '<', $now->format('Y-m-d'))
                  ->orWhere(function($query) use ($now) {
                      $query->where('date', '=', $now->format('Y-m-d'))
                            ->where('end_time', '<=', $now->format('H:i:s'));
                  });
        })
        ->update(['status' => 'expire']);

        // Yıllık izinler için benzer şekilde kontrol yap
        $user->leaveRequests()->where('status', 'approved')
            ->where('end_date', '<', $now->format('Y-m-d'))
            ->update(['status' => 'expire']);

        // Sadece aktif izinleri al
        $activeShortLeaves = $user->shortLeaves()->where('status', 'approved')->get();
        $activeAnnualLeaves = $user->leaveRequests()->where('status', 'approved')->get();
    
        return view('dashboard', compact('activeShortLeaves', 'activeAnnualLeaves'));
    }

    public function getSessionData()
    {
        $sessions = DB::table('sessions')->get();

        return response()->json($sessions);
    }
}


