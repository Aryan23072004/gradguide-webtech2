@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Write a Review</h1>
            <p class="text-gray-600 mt-2">Share your experience with a course and professor</p>
        </div>

        <!-- Review Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
            <form method="POST" action="{{ route('reviews.store') }}" class="space-y-8">
                @csrf

                <!-- Course and Professor Selection -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-book mr-2"></i>Course
                        </label>
                        <select name="course_id" id="course_id" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->code }} - {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="professor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Professor
                        </label>
                        <select name="professor_id" id="professor_id" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Select a professor</option>
                            @foreach($professors as $professor)
                                <option value="{{ $professor->id }}" {{ old('professor_id') == $professor->id ? 'selected' : '' }}>
                                    {{ $professor->name }} ({{ $professor->department }})
                                </option>
                            @endforeach
                        </select>
                        @error('professor_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">
                        <i class="fas fa-star mr-2"></i>Overall Rating
                    </label>
                    <div class="flex items-center space-x-4">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="relative">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ old('rating') == $i ? 'checked' : '' }}>
                                <div class="w-12 h-12 border-2 border-gray-300 rounded-lg flex items-center justify-center cursor-pointer hover:border-yellow-400 transition-colors rating-option">
                                    <i class="fas fa-star text-gray-300 text-xl"></i>
                                </div>
                            </label>
                        @endfor
                        <span class="text-sm text-gray-500 ml-4 rating-text">Select a rating</span>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Review Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-edit mr-2"></i>Your Review
                    </label>
                    <textarea name="content" id="content" rows="8" required 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                              placeholder="Share your experience with this course and professor. What did you like? What could be improved? How was the difficulty level? Any tips for future students?"
                              maxlength="2000">{{ old('content') }}</textarea>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-sm text-gray-500">Be specific and constructive in your feedback</p>
                        <span class="text-sm text-gray-500">
                            <span id="char-count">0</span>/2000
                        </span>
                    </div>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                    <a href="{{ route('reviews.index') }}" 
                       class="text-gray-600 hover:text-gray-800 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
                    </a>
                    <div class="flex space-x-4">
                        <button type="button" onclick="document.getElementById('content').value = ''" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            <i class="fas fa-eraser mr-2"></i>Clear
                        </button>
                        <button type="submit" 
                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Review
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">
                <i class="fas fa-lightbulb mr-2"></i>Writing Tips
            </h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div>
                    <h4 class="font-medium mb-2">What to include:</h4>
                    <ul class="space-y-1">
                        <li>• Course difficulty and workload</li>
                        <li>• Teaching style and effectiveness</li>
                        <li>• Course materials and resources</li>
                        <li>• Assessment methods</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Be constructive:</h4>
                    <ul class="space-y-1">
                        <li>• Provide specific examples</li>
                        <li>• Suggest improvements</li>
                        <li>• Share study tips</li>
                        <li>• Keep it respectful</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Rating selection
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const rating = parseInt(this.value);
            const ratingText = document.querySelector('.rating-text');
            const options = document.querySelectorAll('.rating-option');
            
            // Update stars
            options.forEach((option, index) => {
                const star = option.querySelector('i');
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                    option.classList.add('border-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                    option.classList.remove('border-yellow-400');
                }
            });
            
            // Update text
            const texts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = texts[rating] || 'Select a rating';
        });
    });

    // Character counter
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    
    textarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        
        if (this.value.length > 1800) {
            charCount.classList.add('text-red-600');
        } else {
            charCount.classList.remove('text-red-600');
        }
    });

    // Initialize rating if there's an old value
    const selectedRating = document.querySelector('input[name="rating"]:checked');
    if (selectedRating) {
        selectedRating.dispatchEvent(new Event('change'));
    }
</script>
@endsection
