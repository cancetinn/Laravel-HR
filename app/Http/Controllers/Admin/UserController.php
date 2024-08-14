<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    
        $user = new User($request->all());
        $user->name = $request->first_name . ' ' . $request->last_name;
    
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
    
        $user->save();
    
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

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->title = $request->title;
        $user->phone = $request->phone;
        $user->department = $request->department;
        $user->joining_date = $request->joining_date;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

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
