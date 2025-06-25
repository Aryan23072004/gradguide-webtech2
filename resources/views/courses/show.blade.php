@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $course->name }} ({{ $course->code }})</h1>
    <p><strong>Department:</strong> {{ $course->department }}</p>
    <p><strong>Average Rating:</strong> {{ number_format($averageRating, 1) ?? 'N/A' }}</p>

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