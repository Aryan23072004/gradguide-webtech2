@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Professor Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $professor->name }}</h1>
                <p class="text-lg text-gray-600 mb-4">{{ $professor->department }}</p>
                
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Rating:</span>
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-{{ $i <= $averageRating ? 'yellow' : 'gray' }}-400"></i>
                            @endfor
                            <span class="text-sm font-medium text-gray-900 ml-1">
                                {{ number_format($averageRating, 1) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Reviews:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $reviews->total() }}</span>
                    </div>
                </div>
            </div>
            
            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    @if($reviews->total() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Rating Distribution</h2>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600 w-16">{{ $i }} stars</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $reviews->total() > 0 ? ($ratingDistribution[$i] / $reviews->total() * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-900 w-12">{{ $ratingDistribution[$i] }}</span>
                </div>
            @endfor
        </div>
    </div>
    @endif

    <!-- Courses Taught -->
    @if($courses->count() > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Courses Taught</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($courses as $course)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $course->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $course->code }} - {{ $course->department }}</p>
                    <a href="{{ route('courses.show', $course->id) }}" 
                       class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium hover:bg-blue-700">
                        View Course
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Reviews -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Student Reviews</h2>
        
        @if($reviews->count() > 0)
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400 text-sm"></i>
                                @endfor
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        
                        @if($review->course)
                        <div class="mb-3">
                            <span class="text-sm text-gray-600">Course: </span>
                            <span class="text-sm font-medium text-gray-900">{{ $review->course->name }}</span>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <p class="text-gray-700 leading-relaxed">{{ $review->content }}</p>
                        </div>
                        
                        @if($review->comments->count() > 0)
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <h5 class="text-sm font-medium text-gray-900 mb-2">Comments ({{ $review->comments->count() }})</h5>
                            <div class="space-y-2">
                                @foreach($review->comments as $comment)
                                    <div class="bg-gray-50 rounded p-2">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No reviews yet</h3>
                <p class="text-gray-600 mb-4">Be the first to review this professor!</p>
                @auth
                    <a href="{{ route('reviews.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                        Write Review
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection 