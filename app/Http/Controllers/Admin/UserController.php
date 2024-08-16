<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer|in:0,1,2,3',
            'title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
        ]);

        $data = $request->except(['password', 'profile_image']);
        $data['password'] = Hash::make($request->password);
        $data['name'] = $request->first_name . ' ' . $request->last_name;

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|integer|in:0,1,2,3',
            'title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->except(['password', 'profile_image']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function edit(User $user)
    {
        $documents = Document::where('user_id', $user->id)->get();
        return view('admin.users.edit', compact('user', 'documents'));
    }

    public function destroy(User $user)
    {
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }
}
