@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-blue-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100">Ready to explore courses and share your experiences?</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('courses.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Browse Courses</h3>
                    <p class="text-gray-600 text-sm">Find and review courses</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('professors.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-chalkboard-teacher text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Browse Professors</h3>
                    <p class="text-gray-600 text-sm">Find and review professors</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('reviews.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">All Reviews</h3>
                    <p class="text-gray-600 text-sm">See what others are saying</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('reviews.create') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-purple-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Write Review</h3>
                    <p class="text-gray-600 text-sm">Share your experience</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Reviews</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->reviews()->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Comments Made</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->comments()->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comment text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Reports Submitted</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->reports()->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-4">
            @php
                $recentReviews = Auth::user()->reviews()->latest()->take(3)->get();
            @endphp
            
            @if($recentReviews->count() > 0)
                <div class="space-y-3">
                    @foreach($recentReviews as $review)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    You reviewed {{ $review->course->name }} with {{ $review->professor->name }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400 text-xs"></i>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-star text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">No reviews yet. Start by writing your first review!</p>
                    <a href="{{ route('reviews.create') }}" class="inline-block mt-3 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Write Your First Review
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
