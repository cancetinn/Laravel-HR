<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    public function index()
    {
        $documents = auth()->user()->documents()->get();
        return view('documents.index', compact('documents'));
    }

    public function downloadDocument(Document $document)
    {
        return Storage::download('documents/' . $document->document_name);
    }
}




