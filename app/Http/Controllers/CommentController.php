<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'text' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'review_id' => $request->review_id,
            'text' => $request->text,
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    // Show edit form for comment
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns this comment or is admin
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('comments.edit', compact('comment'));
    }

    // Update comment
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns this comment or is admin
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        $comment->update([
            'text' => $request->text,
        ]);

        return redirect()->route('reviews.show', $comment->review_id)->with('success', 'Comment updated!');
    }

    // Delete comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Check if user owns this comment or is admin
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $reviewId = $comment->review_id;
        $comment->delete();
        
        return redirect()->route('reviews.show', $reviewId)->with('success', 'Comment deleted!');
    }
} 