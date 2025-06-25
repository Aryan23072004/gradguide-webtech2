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
        $query = Professor::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('department', 'like', '%'.$request->search.'%');
        }
        $professors = $query->paginate(10);
        return view('professors.index', compact('professors'));
    }

    // Show a single professor with courses and reviews
    public function show($id)
    {
        $professor = Professor::findOrFail($id);
        $courses = Course::where('professor_id', $id)->get();
        $reviews = $professor->reviews()->with('user')->latest()->paginate(5);
        $averageRating = $professor->reviews()->avg('rating');
        $ratingDistribution = $professor->reviews()->selectRaw('rating, count(*) as count')->groupBy('rating')->pluck('count', 'rating');
        return view('professors.show', compact('professor', 'courses', 'reviews', 'averageRating', 'ratingDistribution'));
    }
} 