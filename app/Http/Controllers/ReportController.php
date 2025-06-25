<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show report form
    public function create(Request $request)
    {
        $type = $request->type; // 'review' or 'comment'
        $id = $request->id;
        
        if ($type === 'review') {
            $content = Review::findOrFail($id);
        } elseif ($type === 'comment') {
            $content = Comment::findOrFail($id);
        } else {
            abort(404);
        }

        return view('reports.create', compact('content', 'type', 'id'));
    }

    // Store report
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:review,comment',
            'content_id' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        $reportData = [
            'user_id' => Auth::id(),
            'reason' => $request->reason,
        ];

        if ($request->type === 'review') {
            $reportData['review_id'] = $request->content_id;
        } else {
            $reportData['comment_id'] = $request->content_id;
        }

        Report::create($reportData);

        return redirect()->back()->with('success', 'Report submitted successfully!');
    }

    // Show user's reports
    public function myReports()
    {
        $reports = Report::where('user_id', Auth::id())
                        ->with('review', 'comment')
                        ->latest()
                        ->paginate(10);
        
        return view('reports.my-reports', compact('reports'));
    }
} 