@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Edit Review</h1>
            <p class="text-gray-600 mt-1">Update your review for {{ $review->course->name }} with {{ $review->professor->name }}</p>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('reviews.update', $review) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Course Selection -->
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                    <select name="course_id" id="course_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $review->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->code }} - {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Professor Selection -->
                <div>
                    <label for="professor_id" class="block text-sm font-medium text-gray-700 mb-2">Professor</label>
                    <select name="professor_id" id="professor_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($professors as $professor)
                            <option value="{{ $professor->id }}" {{ $review->professor_id == $professor->id ? 'selected' : '' }}>
                                {{ $professor->name }} - {{ $professor->department }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex items-center space-x-4">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="flex items-center">
                                <input type="radio" name="rating" value="{{ $i }}" 
                                       {{ $review->rating == $i ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</span>
                            </label>
                        @endfor
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Review Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Review Content</label>
                    <textarea name="content" id="content" rows="6" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Share your experience with this course and professor...">{{ old('content', $review->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Minimum 10 characters required.</p>
                </div>
                
                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('reviews.show', $review) }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-400">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Update Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 