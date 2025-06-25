@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $professor->name }}</h1>
    <p><strong>Department:</strong> {{ $professor->department }}</p>
    <p><strong>Average Rating:</strong> {{ number_format($averageRating, 1) ?? 'N/A' }}</p>
    <p><strong>Total Reviews:</strong> {{ $reviews->total() }}</p>

    <h4>Rating Distribution</h4>
    <div style="max-width: 400px;">
        @for($i = 5; $i >= 1; $i--)
            <div class="d-flex align-items-center mb-1">
                <span class="me-2">{{ $i }} stars</span>
                <div style="background: #eee; width: 200px; height: 16px; position: relative;">
                    <div style="background: #007bff; width: {{ isset($ratingDistribution[$i]) ? ($ratingDistribution[$i] / max(1, $reviews->total()) * 100) : 0 }}%; height: 100%;"></div>
                </div>
                <span class="ms-2">{{ $ratingDistribution[$i] ?? 0 }}</span>
            </div>
        @endfor
    </div>

    <h4 class="mt-4">Courses Taught</h4>
    @if($courses->count() > 0)
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->name }}</h5>
                            <p class="card-text">{{ $course->code }} - {{ $course->department }}</p>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary btn-sm">View Course</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No courses found for this professor.</p>
    @endif

    <h4 class="mt-4">Reviews</h4>
    @foreach($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <strong>{{ $review->user->name }}</strong> - <span>{{ $review->created_at->diffForHumans() }}</span>
                <div>Rating: {{ $review->rating }}</div>
                <p>{{ $review->text }}</p>
            </div>
        </div>
    @endforeach
    {{ $reviews->links() }}
</div>
@endsection 