@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Comments</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Comment</th>
                        <th>On Review</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ Str::limit($comment->text, 100) }}</td>
                            <td>{{ $comment->review->course->name }} - {{ $comment->review->professor->name }}</td>
                            <td>{{ $comment->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('reviews.show', $comment->review_id) }}" class="btn btn-info btn-sm">View</a>
                                <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection 