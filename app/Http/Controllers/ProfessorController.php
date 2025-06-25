<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Course;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // List all professors with optional search and filtering
    public function index(Request $request)
    {
        $query = Professor::withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Rating filter
        if ($request->filled('rating')) {
            $minRating = $request->rating;
            $query->whereHas('reviews', function($q) use ($minRating) {
                $q->havingRaw('AVG(rating) >= ?', [$minRating]);
            });
        }

        // Sorting
        switch ($request->get('sort', 'name')) {
            case 'rating':
                $query->orderByRaw('(SELECT AVG(rating) FROM reviews WHERE reviews.professor_id = professors.id) DESC NULLS LAST');
                break;
            case 'reviews_count':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $professors = $query->paginate(8)->withQueryString();
        
        // Get unique departments for filter dropdown
        $departments = Professor::distinct()->pluck('department')->sort()->values();

        return view('professors.index', compact('professors', 'departments'));
    }

    // Show a single professor with courses and reviews
    public function show(Professor $professor)
    {
        $professor->load(['reviews.user', 'reviews.course', 'reviews.comments.user']);
        
        $reviews = $professor->reviews()
            ->with(['user', 'course', 'comments.user'])
            ->latest()
            ->paginate(10);

        // Calculate average rating
        $averageRating = $professor->reviews()->avg('rating') ?? 0;
        
        // Calculate rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $professor->reviews()->where('rating', $i)->count();
        }
        
        // Get courses taught by this professor
        $courses = Course::whereHas('reviews', function($query) use ($professor) {
            $query->where('professor_id', $professor->id);
        })->distinct()->get();

        return view('professors.show', compact('professor', 'reviews', 'averageRating', 'ratingDistribution', 'courses'));
    }

    // API endpoint for search suggestions
    public function searchSuggestions(Request $request)
    {
        $search = $request->get('q', '');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $suggestions = Professor::where('name', 'like', "%{$search}%")
            ->orWhere('department', 'like', "%{$search}%")
            ->select('id', 'name', 'department')
            ->limit(15)
            ->get()
            ->map(function($professor) {
                return [
                    'id' => $professor->id,
                    'text' => "{$professor->name} ({$professor->department})",
                    'name' => $professor->name,
                    'department' => $professor->department
                ];
            });

        // Add some smart suggestions based on common search patterns
        $smartSuggestions = [];
        
        // If searching for "Dr." or "Prof.", suggest all professors
        if (stripos($search, 'dr') !== false || stripos($search, 'prof') !== false) {
            $smartSuggestions = Professor::select('id', 'name', 'department')
                ->limit(10)
                ->get()
                ->map(function($professor) {
                    return [
                        'id' => $professor->id,
                        'text' => "{$professor->name} ({$professor->department})",
                        'name' => $professor->name,
                        'department' => $professor->department
                    ];
                });
        }
        
        // If searching for "Computer Science" or "CS", suggest all CS professors
        if (stripos($search, 'computer') !== false || stripos($search, 'cs') !== false) {
            $smartSuggestions = Professor::where('department', 'Computer Science')
                ->select('id', 'name', 'department')
                ->limit(10)
                ->get()
                ->map(function($professor) {
                    return [
                        'id' => $professor->id,
                        'text' => "{$professor->name} ({$professor->department})",
                        'name' => $professor->name,
                        'department' => $professor->department
                    ];
                });
        }

        // Combine and deduplicate suggestions
        $allSuggestions = $suggestions->merge($smartSuggestions)->unique('id')->values();
        
        return response()->json($allSuggestions);
    }
} 