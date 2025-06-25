@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Professors</h1>
            <p class="text-gray-600 mt-1">Discover and review professors from various departments</p>
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
            <div class="grid md:grid-cols-3 gap-4">
                <div class="relative">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Professors</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search by professor name or department..."
                           autocomplete="off">
                    <div id="search-suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto"></div>
                </div>
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <select name="department" id="department" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                    <select name="rating" id="rating" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Any Rating</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                @if(request('search') || request('department') || request('rating'))
                    <a href="{{ route('professors.index') }}" class="text-gray-600 hover:text-gray-800">
                        Clear Filters
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Results Count -->
    <div class="flex items-center justify-between">
        <p class="text-gray-600 results-count">
            Showing {{ $professors->count() }} of {{ $professors->total() }} professors
        </p>
    </div>

    <!-- Professors Grid -->
    @if($professors->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($professors as $professor)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md" 
                     data-professor 
                     data-professor-name="{{ $professor->name }}"
                     data-professor-department="{{ $professor->department }}"
                     data-professor-rating="{{ $professor->average_rating }}">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $professor->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $professor->department }}</p>
                            </div>
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-green-600 text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Department:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $professor->department }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Rating:</span>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-{{ $i <= $professor->average_rating ? 'yellow' : 'gray' }}-400 text-sm"></i>
                                    @endfor
                                    <span class="text-sm font-medium text-gray-900 ml-1">
                                        {{ number_format($professor->average_rating, 1) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Reviews:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $professor->reviews_count }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <a href="{{ route('professors.show', $professor) }}" 
                               class="w-full bg-blue-600 text-white py-2 px-3 rounded-md text-sm font-medium hover:bg-blue-700 text-center block">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($professors->hasPages())
            <div class="mt-6">
                {{ $professors->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No professors found</h3>
            <p class="text-gray-600 mb-4">Try adjusting your search criteria.</p>
            <a href="{{ route('professors.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                View All Professors
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const departmentSelect = document.getElementById('department');
    const ratingSelect = document.getElementById('rating');
    const professorCards = document.querySelectorAll('[data-professor]');
    const suggestionsDiv = document.getElementById('search-suggestions');
    let timeoutId;

    // Auto-search function
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedDepartment = departmentSelect.value.toLowerCase();
        const selectedRating = parseFloat(ratingSelect.value) || 0;
        
        professorCards.forEach(card => {
            const professorName = card.getAttribute('data-professor-name').toLowerCase();
            const professorDepartment = card.getAttribute('data-professor-department').toLowerCase();
            const professorRating = parseFloat(card.getAttribute('data-professor-rating')) || 0;
            
            // More flexible search - check if any part matches
            const matchesSearch = !searchTerm || 
                professorName.includes(searchTerm) || 
                professorDepartment.includes(searchTerm) ||
                professorName.split(' ').some(word => word.startsWith(searchTerm));
            
            const matchesDepartment = !selectedDepartment || professorDepartment === selectedDepartment;
            const matchesRating = selectedRating === 0 || professorRating >= selectedRating;
            
            if (matchesSearch && matchesDepartment && matchesRating) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        updateResultsCount();
    }

    // Update results count
    function updateResultsCount() {
        const visibleCards = document.querySelectorAll('[data-professor]:not([style*="display: none"])');
        const totalCards = professorCards.length;
        const resultsElement = document.querySelector('.results-count');
        if (resultsElement) {
            resultsElement.textContent = `Showing ${visibleCards.length} of ${totalCards} professors`;
        }
    }

    // Search input event
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(performSearch, 300);
    });

    // Department select event
    departmentSelect.addEventListener('change', performSearch);

    // Rating select event
    ratingSelect.addEventListener('change', performSearch);

    // Search suggestions
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();
        
        if (query.length < 2) {
            suggestionsDiv.classList.add('hidden');
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`{{ route('professors.suggestions') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(suggestions => {
                    suggestionsDiv.innerHTML = '';
                    
                    if (suggestions.length > 0) {
                        suggestions.forEach(suggestion => {
                            const div = document.createElement('div');
                            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                            div.textContent = suggestion.text;
                            div.addEventListener('click', () => {
                                // Extract just the professor name from the suggestion
                                const professorName = suggestion.text.split(' (')[0];
                                searchInput.value = professorName;
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

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.classList.add('hidden');
        }
    });

    // Initialize results count
    updateResultsCount();
});
</script>
@endsection 