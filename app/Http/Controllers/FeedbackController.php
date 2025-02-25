<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Book;

class FeedbackController extends Controller
{

    public function index()
    {
        $feedbacks = Feedback::with(['user', 'book'])->get();
        return view('feedback.index', compact('feedbacks'));
    }
// app/Http/Controllers/FeedbackController.php
// app/Http/Controllers/FeedbackController.php
    public function create($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('feedback.create', compact('book'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('book.index')->with('success', 'Feedback berhasil dikirim!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); // Cari feedback berdasarkan ID
        $feedback->delete(); // Hapus feedback

        return redirect()->route('index')->with('success', 'Feedback deleted successfully!');
    }
}