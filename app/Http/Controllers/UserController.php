<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showDocuments()
    {
        $documents = auth()->user()->documents()->get();

        return view('user.documents', compact('documents'));
    }
}

