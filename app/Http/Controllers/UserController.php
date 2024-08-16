<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showDocuments()
    {
        $documents = Auth::user()->documents;

        return view('user.documents', compact('documents'));
    }
}
