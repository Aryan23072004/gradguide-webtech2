@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Review Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $review->user ? substr($review->user->name, 0, 1) : '?' }}</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">{{ $review->user ? $review->user->name : 'Unknown User' }}</h1>
                            <p class="text-sm text-gray-500">{{ $review->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                        @if($review->course)
                        <span class="flex items-center">
                            <i class="fas fa-book mr-1"></i>
                            {{ $review->course->name }} ({{ $review->course->code }})
                        </span>
                        @endif
                        @if($review->professor)
                        <span class="flex items-center">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>
                            {{ $review->professor->name }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400 text-lg"></i>
                        @endfor
                        <span class="text-lg font-medium text-gray-900 ml-2">{{ $review->rating }}/5</span>
                    </div>
                </div>
                
                @auth
                    @if($review->user && Auth::user()->id === $review->user_id)
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('reviews.edit', $review) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-blue-700">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
            
            <!-- Review Content -->
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed text-base">{{ $review->content }}</p>
            </div>
            
            <!-- Review Stats -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200 mt-4">
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <i class="fas fa-thumbs-up mr-1"></i>
                        {{ $review->helpful_votes ?? 0 }} helpful
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-comment mr-1"></i>
                        {{ $review->comments()->count() }} comments
                    </span>
                </div>
                
                <a href="{{ route('reviews.index') }}" 
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    ← Back to Reviews
                </a>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Comments ({{ $review->comments()->count() }})</h2>
        </div>
        
        <div class="p-6">
            @auth
                <!-- Add Comment Form -->
                <form method="POST" action="{{ route('comments.store') }}" class="mb-6">
                    @csrf
                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                        <textarea name="content" id="content" rows="3" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Share your thoughts..."></textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                            Post Comment
                        </button>
                    </div>
                </form>
            @else
                <div class="mb-6 p-4 bg-gray-50 rounded-md">
                    <p class="text-gray-600 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Sign in</a> 
                        to add a comment.
                    </p>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($review->comments()->with('user')->latest()->get() as $comment)
                    <div class="flex space-x-3 p-4 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-medium">{{ $comment->user ? substr($comment->user->name, 0, 1) : '?' }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-900">{{ $comment->user ? $comment->user->name : 'Unknown User' }}</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                            
                            @auth
                                @if($comment->user && Auth::user()->id === $comment->user_id)
                                    <div class="mt-2 flex items-center space-x-2">
                                        <a href="{{ route('comments.edit', $comment) }}" 
                                           class="text-blue-600 hover:text-blue-700 text-xs font-medium">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-700 text-xs font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 