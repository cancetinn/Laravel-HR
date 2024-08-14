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
        $user = auth()->user();
    
        if ($user->role == 1) {
            // Admin tüm kullanıcıları görür
            $users = User::withCount(['shortLeaves' => function ($query) {
                $query->where('status', 'pending');
            }])->get();
        } elseif ($user->role == 2) {
            // Grafik Tasarım departmanını sadece role 2 olan kullanıcılar görsün
            $users = User::where('department', 1) // Grafik Tasarım departmanı (1)
                ->withCount(['shortLeaves' => function ($query) {
                    $query->where('status', 'pending');
                }])->get();
        } else {
            // Diğer kullanıcılar veri göremez
            $users = collect();
        }
    
        return view('admin.short_leaves.index', compact('users'));
    }      
    
    
    public function show($userId)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($userId);

        if ($currentUser->role == 1 || ($currentUser->role == 2 && $user->department == 1) || ($currentUser->role == 3 && $user->department == 3)) {
            $user = User::with('shortLeaves')->findOrFail($userId);
            $logs = ShortLeaveLog::whereHas('shortLeave', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();

            return view('admin.short_leaves.show', compact('user', 'logs'));
        } else {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }
    }

    public function update(Request $request, $id)
    {
        $shortLeave = ShortLeave::findOrFail($id);
        $currentUser = auth()->user();

        if ($currentUser->role == 1 || ($currentUser->department == $shortLeave->user->department && in_array($currentUser->role, [2, 3]))) {
            $action = $request->input('action');
            $shortLeave->status = $action === 'approve' ? 'approved' : 'rejected';
            $shortLeave->save();

            ShortLeaveLog::create([
                'short_leave_id' => $shortLeave->id,
                'admin_id' => $currentUser->id,
                'action' => $action,
                'remarks' => $request->input('remarks'),
            ]);

            return redirect()->route('admin.short_leaves.show', $shortLeave->user_id)->with('success', 'İzin talebi güncellendi.');
        } else {
            abort(403, 'Bu işlemi gerçekleştirme yetkiniz yok.');
        }
    }
}
