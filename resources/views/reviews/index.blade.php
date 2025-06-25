@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reviews</h1>
            <p class="text-gray-600 mt-1">Read and discover student experiences with courses and professors</p>
        </div>
        @auth
            <a href="{{ route('reviews.create') }}" class="mt-4 md:mt-0 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                Write Review
            </a>
        @endauth
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Reviews</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search by course, professor, or content...">
                    <div id="search-suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                </div>
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select name="rating" id="rating" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                @if(request('search') || request('rating'))
                    <a href="{{ route('reviews.index') }}" class="text-gray-600 hover:text-gray-800">
                        Clear Filters
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Results Count -->
    <div class="flex items-center justify-between">
        <p class="text-gray-600 results-count">
            Showing {{ $reviews->count() }} reviews
        </p>
    </div>

    <!-- Reviews List -->
    @if($reviews->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($reviews as $review)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md"
                     data-review
                     data-review-course="{{ $review->course?->name ?? 'N/A' }}"
                     data-review-professor="{{ $review->professor?->name ?? 'N/A' }}"
                     data-review-content="{{ $review->content }}"
                     data-review-rating="{{ $review->rating }}"
                     data-review-type="both">
                    <div class="p-4">
                        <!-- Review Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $review->user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-book mr-1"></i>
                                        {{ $review->course?->name ?? 'N/A' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        {{ $review->professor?->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400"></i>
                                @endfor
                                <span class="text-sm font-medium text-gray-900 ml-2">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        
                        <!-- Review Content -->
                        <div class="mb-3">
                            <p class="text-gray-700 leading-relaxed">{{ Str::limit($review->content, 200) }}</p>
                            @if(strlen($review->content) > 200)
                                <a href="{{ route('reviews.show', $review) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Read more...
                                </a>
                            @endif
                        </div>
                        
                        <!-- Review Stats -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
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
                            
                            @auth
                                @if(Auth::user()->id === $review->user_id)
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('reviews.edit', $review) }}" 
                                           class="text-green-600 hover:text-green-700 text-sm font-medium">
                                            Edit
                                        </a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No reviews found</h3>
            <p class="text-gray-600 mb-4">Try adjusting your search criteria.</p>
            <a href="{{ route('reviews.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                View All Reviews
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const ratingSelect = document.getElementById('rating');
    const reviewCards = document.querySelectorAll('[data-review]');
    let timeoutId;

    // Auto-search function
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedRating = parseInt(ratingSelect.value) || 0;
        reviewCards.forEach(card => {
            const courseName = card.getAttribute('data-review-course').toLowerCase();
            const professorName = card.getAttribute('data-review-professor').toLowerCase();
            const content = card.getAttribute('data-review-content').toLowerCase();
            const rating = parseInt(card.getAttribute('data-review-rating')) || 0;
            // More flexible search - check if any part matches
            const matchesSearch = !searchTerm || 
                courseName.includes(searchTerm) || 
                professorName.includes(searchTerm) || 
                content.includes(searchTerm) ||
                courseName.split(' ').some(word => word.startsWith(searchTerm)) ||
                professorName.split(' ').some(word => word.startsWith(searchTerm));
            const matchesRating = selectedRating === 0 || rating === selectedRating;
            if (matchesSearch && matchesRating) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        updateResultsCount();
    }

    // Update results count
    function updateResultsCount() {
        const visibleCards = document.querySelectorAll('[data-review]:not([style*="display: none"])');
        const totalCards = reviewCards.length;
        const resultsElement = document.querySelector('.results-count');
        if (resultsElement) {
            resultsElement.textContent = `Showing ${visibleCards.length} of ${totalCards} reviews`;
        }
    }

    // Search input event
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(performSearch, 300);
        // Search suggestions
        const query = this.value.trim();
        const suggestionsDiv = document.getElementById('search-suggestions');
        if (query.length < 2) {
            suggestionsDiv.classList.add('hidden');
            return;
        }
        timeoutId = setTimeout(() => {
            fetch(`{{ route('reviews.suggestions') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(suggestions => {
                    suggestionsDiv.innerHTML = '';
                    if (suggestions.length > 0) {
                        suggestions.forEach(suggestion => {
                            const div = document.createElement('div');
                            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100';
                            div.textContent = suggestion.text;
                            div.addEventListener('click', () => {
                                // Extract the relevant part based on suggestion type
                                let searchValue = '';
                                if (suggestion.type === 'course') {
                                    searchValue = suggestion.name;
                                } else if (suggestion.type === 'professor') {
                                    searchValue = suggestion.name;
                                } else if (suggestion.type === 'content') {
                                    searchValue = suggestion.text.replace('Review: ', '').replace('...', '');
                                }
                                searchInput.value = searchValue;
                                suggestionsDiv.classList.add('hidden');
                                performSearch();
                            });
                            suggestionsDiv.appendChild(div);
                        });
                        suggestionsDiv.classList.remove('hidden');
                    } else {
                        suggestionsDiv.classList.add('hidden');
                    }
                });
        }, 300);
    });

    // Rating select event
    ratingSelect.addEventListener('change', performSearch);
    // Initialize results count
    updateResultsCount();
});
</script>
@endsection 