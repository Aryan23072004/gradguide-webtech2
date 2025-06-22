<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'role' => auth()->user()->role,
            'message' => $request->message,
        ]);

        return redirect()->route('feedback.create')->with('success', 'Feedback submitted successfully.');
    }
}
