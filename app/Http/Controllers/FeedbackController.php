<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{

    public function index()
    {
        $feedbacks = Feedback::all();
        return view('feedback.index', compact('feedbacks'));
    }
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('index')->with('success', 'Feedback submitted successfully!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); // Cari feedback berdasarkan ID
        $feedback->delete(); // Hapus feedback

        return redirect()->route('index')->with('success', 'Feedback deleted successfully!');
    }
}