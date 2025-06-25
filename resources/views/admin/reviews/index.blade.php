@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Reviews</h1>

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
                        <th>Course</th>
                        <th>Professor</th>
                        <th>Rating</th>
                        <th>Text</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->user->name }}</td>
                            <td>{{ $review->course->name }}</td>
                            <td>{{ $review->professor->name }}</td>
                            <td>{{ $review->rating }}/5</td>
                            <td>{{ Str::limit($review->text, 50) }}</td>
                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection 