<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->documents;

        return view('documents.index', compact('documents'));
    }

    public function downloadDocument(Document $document)
    {
        return Storage::download('documents/' . $document->document_name);
    }
}
