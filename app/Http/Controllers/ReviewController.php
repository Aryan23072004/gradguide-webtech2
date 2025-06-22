<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Show form to create a review
    public function create()
    {
        $courses = Course::all();
        $professors = Professor::all();
        return view('reviews.create', compact('courses', 'professors'));
    }

    // Store submitted review
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'professor_id' => 'required|exists:professors,id',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'professor_id' => $request->professor_id,
            'rating' => $request->rating,
            'text' => $request->text,
        ]);

        return redirect()->route('reviews.create')->with('success', 'Review submitted!');
    }

    // Show all reviews
    public function index()
    {
        $reviews = Review::with('user', 'course', 'professor')->latest()->get();
        return view('reviews.index', compact('reviews'));
    }
}
