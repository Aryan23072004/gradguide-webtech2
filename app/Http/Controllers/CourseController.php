<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List all courses with optional search and filtering
    public function index(Request $request)
    {
        $query = Course::withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'rating':
                $query->orderByRaw('(SELECT AVG(rating) FROM reviews WHERE reviews.course_id = courses.id) DESC NULLS LAST');
                break;
            case 'reviews_count':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $courses = $query->paginate(8)->withQueryString();
        
        // Get unique departments for filter dropdown
        $departments = Course::distinct()->pluck('department')->sort()->values();

        return view('courses.index', compact('courses', 'departments'));
    }

    // API endpoint for search suggestions
    public function searchSuggestions(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $suggestions = Course::where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orWhere('department', 'like', "%{$search}%")
            ->select('id', 'name', 'code', 'department')
            ->limit(10)
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'text' => "{$course->code} - {$course->name} ({$course->department})"
                ];
            });

        return response()->json($suggestions);
    }

    // Show a single course with reviews and average rating
    public function show(Course $course)
    {
        // Eager load reviews_count and average_rating for consistency
        $course->loadCount('reviews');
        $course->loadAvg('reviews', 'rating');
        $course->load(['reviews.user', 'reviews.professor', 'reviews.comments.user']);

        $reviews = $course->reviews()
            ->with(['user', 'professor', 'comments.user'])
            ->latest()
            ->paginate(10);

        // Calculate rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $course->reviews()->where('rating', $i)->count();
        }

        return view('courses.show', [
            'course' => $course,
            'reviews' => $reviews,
            'averageRating' => $course->average_rating ?? 0,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }
} 