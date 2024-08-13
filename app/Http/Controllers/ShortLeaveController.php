<?php

namespace App\Http\Controllers;

use App\Models\ShortLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ShortLeaveController extends Controller
{
    public function index()
    {
        $shortLeaves = ShortLeave::where('user_id', Auth::id())->get();
        return view('short_leaves.index', compact('shortLeaves'));
    }

    public function create()
    {
        $shortLeaves = auth()->user()->shortLeaves;
        return view('short_leaves.create', compact('shortLeaves'));
    }

    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'reason' => 'required|string|max:255',
    ]);

    ShortLeave::create([
        'user_id' => auth()->id(),
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'duration' => Carbon::parse($request->start_time)->diffInMinutes(Carbon::parse($request->end_time)),
        'reason' => $request->reason,  // reason burada alınıyor
        'status' => 'pending',
    ]);

    return redirect()->route('short_leaves.create')->with('success', 'Kısa izin talebiniz başarıyla oluşturuldu.');
}

    public function show(ShortLeave $shortLeave)
    {
        return view('short_leaves.show', compact('shortLeave'));
    }

    public function destroy(ShortLeave $shortLeave)
    {
        $shortLeave->delete();
        return redirect()->route('short_leaves.index')->with('success', 'İzin talebi başarıyla silindi.');
    }
}
