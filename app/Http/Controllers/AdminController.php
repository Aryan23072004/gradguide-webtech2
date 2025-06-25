<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Course;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalReviews = Review::count();
        $totalComments = Comment::count();
        $pendingReports = Report::where('status', 'pending')->count();

        // Create recent activity data
        $recentActivity = [];
        
        // Add recent reports
        $recentReports = Report::with('user')->latest()->take(3)->get();
        foreach ($recentReports as $report) {
            $recentActivity[] = [
                'icon' => 'flag',
                'message' => "Report submitted by {$report->user->name}",
                'time' => $report->created_at->diffForHumans()
            ];
        }
        
        // Add recent reviews
        $recentReviews = Review::with('user')->latest()->take(3)->get();
        foreach ($recentReviews as $review) {
            $recentActivity[] = [
                'icon' => 'star',
                'message' => "Review posted by {$review->user->name}",
                'time' => $review->created_at->diffForHumans()
            ];
        }
        
        // Sort by time and take first 5
        usort($recentActivity, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        $recentActivity = array_slice($recentActivity, 0, 5);

        return view('admin.dashboard', compact('totalUsers', 'totalReviews', 'totalComments', 'pendingReports', 'recentActivity'));
    }

    // Manage Users
    public function users()
    {
        $users = User::withCount('reviews')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        return redirect()->back()->with('success', 'User status updated!');
    }

    // Manage Reviews
    public function reviews()
    {
        $reviews = Review::with('user', 'course', 'professor')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted!');
    }

    // Manage Comments
    public function comments()
    {
        $comments = Comment::with('user', 'review')->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted!');
    }

    // Manage Reports
    public function reports()
    {
        $reports = Report::with('user', 'review')->latest()->paginate(15);
        return view('admin.reports.index', compact('reports'));
    }

    public function resolveReport($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'resolved']);
        return redirect()->back()->with('success', 'Report marked as resolved!');
    }

    public function deleteReportedContent($id)
    {
        $report = Report::findOrFail($id);
        
        if ($report->review_id) {
            $review = Review::find($report->review_id);
            if ($review) {
                $review->delete();
            }
        } elseif ($report->comment_id) {
            $comment = Comment::find($report->comment_id);
            if ($comment) {
                $comment->delete();
            }
        }
        
        $report->update(['status' => 'resolved']);
        return redirect()->back()->with('success', 'Reported content deleted!');
    }
}
