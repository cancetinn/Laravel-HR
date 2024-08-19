<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Auth::user()->expenses;
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string',
            'description' => 'nullable|string',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'expense_date' => 'required|date',
        ]);

        $attachmentPath = $request->file('attachment')->store('expenses', 'public');

        Expense::create([
            'user_id' => Auth::id(),
            'expense_type' => $request->expense_type,
            'description' => $request->description,
            'attachment' => $attachmentPath,
            'expense_date' => $request->expense_date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    public function adminIndex()
    {
        $users = User::withCount('expenses')->get();
        return view('admin.expenses.index', compact('users'));
    }
    
    public function reviewUserExpenses($userId)
    {
        $user = User::with('expenses')->findOrFail($userId);
        return view('admin.expenses.review', compact('user'));
    }

    public function updateStatus(Request $request, Expense $expense)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
            'payment_status' => 'required|in:Pending,Paid',
        ]);

        $expense->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Expense updated successfully.');
    }
}


