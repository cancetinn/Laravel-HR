<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WeatherService;
use App\Models\ShortLeave;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function dashboard(WeatherService $weatherService)
    {
        $now = Carbon::now();

        ShortLeave::where('status', 'approved')
            ->where(function($query) use ($now) {
                $query->where('date', '<', $now->toDateString())
                      ->orWhere(function($query) use ($now) {
                          $query->where('date', $now->toDateString())
                                ->where('end_time', '<=', $now->toTimeString());
                      });
            })->update(['status' => 'expire']);

        LeaveRequest::where('status', 'approved')
            ->where('end_date', '<', $now->toDateString())
            ->update(['status' => 'expire']);

        $activeShortLeaves = ShortLeave::where('status', 'approved')->get();
        $activeAnnualLeaves = LeaveRequest::where('status', 'approved')->get();

        $weather = $weatherService->getIstanbulWeather();
        $temperature = round($weather['main']['temp']);
        $location = 'İstanbul';

        return view('dashboard', compact('activeShortLeaves', 'activeAnnualLeaves', 'temperature', 'location'));
    }

    public function getSessionData()
    {
        $sessions = DB::table('sessions')->get();

        return response()->json($sessions);
    }
}