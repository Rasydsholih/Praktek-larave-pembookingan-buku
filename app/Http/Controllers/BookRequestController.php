<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;
use Illuminate\Support\Facades\Auth;

class BookRequestController extends Controller
{
    // Menampilkan form request book
    public function create()
    {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('index')->with('error', 'Admin tidak dapat membuat request buku.');
        }
        return view('bookrequest.create');
    }

    // Menyimpan request book
    public function store(Request $request)
    {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('index')->with('error', 'Admin tidak dapat membuat request buku.');
        }

        
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'reason' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
    
        BookRequest::create([
            'title' => $request->title,
            'author' => $request->author,
            'reason' => $request->reason,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('index')->with('success', 'Request buku telah terkirim!');
    }

    // Menampilkan daftar request book (untuk admin)
    public function index()
    {
        $requests = BookRequest::with('user')->get();
        return view('bookrequest.index', compact('requests'));
    }

    // Mengubah status request (approve/reject)
    public function updateStatus(Request $request, $id)
    {
        $bookRequest = BookRequest::findOrFail($id);
    
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
    
        $bookRequest->update([
            'status' => $request->status,
        ]);
    
        return redirect()->route('bookrequest.index')->with('success', 'Request status updated successfully!');
    }

    public function show($id)
    {
        $bookRequests = BookRequest::where('status', 'approved')
            ->where('user_id', auth()->id()) // Hanya mengambil data user yang login
            ->get();
    
        return view('bookrequest.show', compact('bookRequests')); // Gunakan 'bookRequests' dengan benar
    }    

    public function destroy($id)
    {
        // Cari data book request berdasarkan ID
        $bookRequest = BookRequest::findOrFail($id);

        // Hapus data
        $bookRequest->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('book.index')->with('success', 'Berhasil menghapus feedback');
    }
    

    
}
