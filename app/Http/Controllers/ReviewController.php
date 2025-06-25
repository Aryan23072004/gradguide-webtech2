<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    // Show form to create a review
    public function create()
    {
        $courses = Course::orderBy('name')->get();
        $professors = Professor::orderBy('name')->get();
        return view('reviews.create', compact('courses', 'professors'));
    }

    // Store submitted review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'professor_id' => 'required|exists:professors,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|min:10',
        ]);

        $validated['user_id'] = auth()->id();

        Review::create($validated);

        return redirect()->route('reviews.index')
            ->with('success', 'Review submitted successfully!');
    }

    // Show all reviews
    public function index(Request $request)
    {
        $query = Review::with(['user', 'course', 'professor'])
            ->withCount('comments');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('course', function($courseQuery) use ($search) {
                      $courseQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('code', 'like', "%{$search}%");
                  })
                  ->orWhereHas('professor', function($profQuery) use ($search) {
                      $profQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('department', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Rating filter
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Type filter (course vs professor focus)
        if ($request->filled('type')) {
            // This is a simplified filter - you might want to add a field to distinguish review focus
            // For now, we'll just pass through the filter
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'helpful':
                $query->orderBy('helpful_votes', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(60)->withQueryString();
        return view('reviews.index', compact('reviews'));
    }

    // Show a single review
    public function show(Review $review)
    {
        $review->load(['user', 'course', 'professor', 'comments.user']);
        return view('reviews.show', compact('review'));
    }

    // Show edit form
    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        
        $courses = Course::orderBy('name')->get();
        $professors = Professor::orderBy('name')->get();
        return view('reviews.edit', compact('review', 'courses', 'professors'));
    }

    // Update review
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'professor_id' => 'required|exists:professors,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|min:10',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Review updated successfully!');
    }

    // Delete review
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();
        
        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    // API endpoint for search suggestions
    public function searchSuggestions(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $suggestions = collect();

        // Search in courses
        $courseSuggestions = \App\Models\Course::where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->select('id', 'name', 'code', 'department')
            ->limit(8)
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'text' => "Course: {$course->code} - {$course->name}",
                    'type' => 'course',
                    'name' => $course->name,
                    'code' => $course->code
                ];
            });

        // Search in professors
        $professorSuggestions = \App\Models\Professor::where('name', 'like', "%{$search}%")
            ->select('id', 'name', 'department')
            ->limit(8)
            ->get()
            ->map(function($professor) {
                return [
                    'id' => $professor->id,
                    'text' => "Professor: {$professor->name}",
                    'type' => 'professor',
                    'name' => $professor->name,
                    'department' => $professor->department
                ];
            });

        // Search in review content
        $contentSuggestions = Review::where('content', 'like', "%{$search}%")
            ->with(['course', 'professor'])
            ->select('id', 'content', 'course_id', 'professor_id')
            ->limit(5)
            ->get()
            ->map(function($review) {
                $content = Str::limit($review->content, 50);
                return [
                    'id' => $review->id,
                    'text' => "Review: {$content}...",
                    'type' => 'content',
                    'course' => $review->course ? $review->course->name : 'Unknown Course',
                    'professor' => $review->professor ? $review->professor->name : 'Unknown Professor'
                ];
            });

        // Combine all suggestions
        $suggestions = $courseSuggestions->merge($professorSuggestions)->merge($contentSuggestions);

        return response()->json($suggestions);
    }
}
