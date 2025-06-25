@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Course Header -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ $course->name }}</h2>
                            <div class="text-muted mb-2">{{ $course->code }}</div>
                            <div class="mb-2"><span class="fw-semibold">Department:</span> {{ $course->department ?: 'N/A' }}</div>
                        </div>
                        <div class="text-center mt-3 mt-md-0">
                            <div class="display-5 fw-bold text-primary">{{ number_format($averageRating, 1) }}</div>
                            <div class="text-muted">Average Rating</div>
                            <div class="text-muted small">Total Reviews: {{ $reviews->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0">Rating Distribution</h6>
                </div>
                <div class="card-body">
                    @for($i = 5; $i >= 1; $i--)
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2" style="width: 40px;">{{ $i }}★</span>
                            <div class="flex-grow-1 mx-2">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $reviews->total() > 0 ? ($ratingDistribution[$i] / $reviews->total() * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <span class="ms-2" style="width: 30px;">{{ $ratingDistribution[$i] ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reviews ({{ $reviews->total() }})</h5>
                    @auth
                        <a href="{{ route('reviews.create') }}?course_id={{ $course->id }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Write Review
                        </a>
                    @endauth
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        @foreach($reviews as $review)
                            <div class="mb-4 pb-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $review->user->name }}</div>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-warning fw-bold">@for($i = 1; $i <= 5; $i++)<i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>@endfor</span>
                                        <div class="small text-muted">{{ $review->rating }}/5</div>
                                    </div>
                                </div>
                                @if($review->professor)
                                    <div class="mb-2">
                                        <small class="text-muted"><i class="fas fa-user-tie me-1"></i>Professor: {{ $review->professor->name }}</small>
                                    </div>
                                @endif
                                <div class="mb-2">{{ $review->text }}</div>
                                @if($review->comments->count() > 0)
                                    <div class="mt-2">
                                        <h6 class="text-muted mb-2">Comments ({{ $review->comments->count() }})</h6>
                                        @foreach($review->comments as $comment)
                                            <div class="bg-light p-2 rounded mb-2">
                                                <div class="d-flex justify-content-between">
                                                    <small><strong>{{ $comment->user->name }}</strong></small>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                                <small>{{ $comment->text }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No reviews yet</h5>
                            <p class="text-muted">Be the first to review this course!</p>
                            @auth
                                <a href="{{ route('reviews.create') }}?course_id={{ $course->id }}" class="btn btn-primary">Write First Review</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Login to Review</a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 1rem;
}
.card-header {
    border-radius: 1rem 1rem 0 0 !important;
}
.progress {
    background-color: #f8f9fa;
    border-radius: 10px;
}
.progress-bar {
    border-radius: 10px;
}
</style>
@endsection 