<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;
    public function index(){

        $documents = Auth::user()->documents()->latest()->get();
        
        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf,docx,txt|max:5120'
    ]);

    $file = $request->file('file');
    $path = $file->store('documents/' . Auth::id(), 'public');

   

        $file = $request->file('file');
        $path = $file->store('/documents' . Auth::id(), 'public');

        Document::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file_path' => $path

        ]);
        return redirect()->route('documents.index')->with('status', 'document uploaded successfully');
    }

    public function download($id){
        $document = Document::findOrFail($id);
        $this->authorize('view', $document);
        $document->increment('downloads');
        $filePath = Storage::disk('public')->path($document->file_path);
        $fileName = $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION);
        return response()->download($filePath, $fileName);

    }

    public function destroy($id){
        $document = Document::findOrFail($id);
        $this->authorize('delete', $document);
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return redirect()->route('documents.index')->with('status', 'document deleted successfully ');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
