<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortLeave;
use App\Models\ShortLeaveLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminShortLeaveController extends Controller
{
    public function index()
    {
        $users = User::withCount(['shortLeaves' => function ($query) {
            $query->where('status', 'pending');
        }])->get();
        
        return view('admin.short_leaves.index', compact('users'));
    }

    public function show($userId)
    {
        $user = User::with('shortLeaves')->findOrFail($userId);
        $logs = ShortLeaveLog::whereHas('shortLeave', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('admin.short_leaves.show', compact('user', 'logs'));
    }

    public function update(Request $request, $id)
    {
        $shortLeave = ShortLeave::findOrFail($id);
        $action = $request->input('action');
        $shortLeave->status = $action === 'approve' ? 'approved' : 'rejected';
        $shortLeave->save();

        ShortLeaveLog::create([
            'short_leave_id' => $shortLeave->id,
            'admin_id' => auth()->id(),
            'action' => $action,
            'remarks' => $request->input('remarks'),
        ]);

        return redirect()->route('admin.short_leaves.show', $shortLeave->user_id)->with('success', 'İzin talebi güncellendi.');
    }
}
