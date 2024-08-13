<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('user')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function showUploadForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.documents.upload', compact('user'));
    }

    public function uploadDocument(Request $request, $userId)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx,jpg,png|max:2048',
            'document_type' => 'required|string',
        ]);

        $documentName = $request->file('document')->getClientOriginalName(); // Dosyanın orijinal adı
        $documentPath = $request->file('document')->storeAs('documents', $documentName, 'public');

        Document::create([
            'user_id' => $userId,
            'admin_id' => auth()->id(),
            'document_name' => $documentName, // Orijinal dosya adını kaydediyoruz
            'document_type' => $request->document_type,
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Belge başarıyla yüklendi.');
    }

    public function downloadDocument(Document $document)
    {
        $filePath = 'public/documents/' . $document->document_name;

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        return redirect()->back()->with('error', 'Belge bulunamadı.');
    }
    
    public function destroy(Document $document)
    {
        Storage::disk('public')->delete('documents/' . $document->document_name);
        $document->delete();

        return redirect()->back()->with('success', 'Belge başarıyla silindi.');
    }
    
}
