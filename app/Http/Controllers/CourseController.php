<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List all courses with optional search and filtering
    public function index(Request $request)
    {
        $query = Course::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('code', 'like', '%'.$request->search.'%');
        }
        $courses = $query->paginate(10);
        return view('courses.index', compact('courses'));
    }

    // Show a single course with reviews and average rating
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $reviews = $course->reviews()->with('user')->latest()->paginate(5);
        $averageRating = $course->reviews()->avg('rating');
        $ratingDistribution = $course->reviews()->selectRaw('rating, count(*) as count')->groupBy('rating')->pluck('count', 'rating');
        return view('courses.show', compact('course', 'reviews', 'averageRating', 'ratingDistribution'));
    }
} 