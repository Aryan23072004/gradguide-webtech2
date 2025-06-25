@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Courses</h1>
            <p class="text-gray-600 mt-1">Discover and review courses from various departments</p>
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
            <div class="grid md:grid-cols-2 gap-4">
                <div class="relative">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Courses</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Search by course name, code, or department..."
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
            </div>
            <div class="flex justify-end">
                @if(request('search') || request('department'))
                    <a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-gray-800">
                        Clear Filters
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Results Count -->
    <div class="flex items-center justify-between">
        <p class="text-gray-600 results-count">
            Showing {{ $courses->count() }} of {{ $courses->total() }} courses
        </p>
    </div>

    <!-- Courses Grid -->
    @if($courses->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($courses as $course)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md" 
                     data-course 
                     data-course-name="{{ $course->name }}"
                     data-course-code="{{ $course->code }}"
                     data-course-department="{{ $course->department }}">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $course->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $course->code }}</p>
                            </div>
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-blue-600 text-sm"></i>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Department:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $course->department }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Rating:</span>
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= 3)
                                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="fas fa-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm font-medium text-gray-900 ml-1">
                                        3.0
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Reviews:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $course->reviews_count }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <a href="{{ route('courses.show', $course) }}" 
                               class="w-full bg-blue-600 text-white py-2 px-3 rounded-md text-sm font-medium hover:bg-blue-700 text-center block">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="mt-6">
                {{ $courses->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses found</h3>
            <p class="text-gray-600 mb-4">Try adjusting your search criteria.</p>
            <a href="{{ route('courses.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700">
                View All Courses
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const departmentSelect = document.getElementById('department');
    const courseCards = document.querySelectorAll('[data-course]');
    const suggestionsDiv = document.getElementById('search-suggestions');
    let timeoutId;

    // Auto-search function
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedDepartment = departmentSelect.value.toLowerCase();
        
        courseCards.forEach(card => {
            const courseName = card.getAttribute('data-course-name').toLowerCase();
            const courseCode = card.getAttribute('data-course-code').toLowerCase();
            const courseDepartment = card.getAttribute('data-course-department').toLowerCase();
            
            // More flexible search - check if any part matches
            const matchesSearch = !searchTerm || 
                courseName.includes(searchTerm) || 
                courseCode.includes(searchTerm) || 
                courseDepartment.includes(searchTerm) ||
                courseName.split(' ').some(word => word.startsWith(searchTerm)) ||
                courseCode.startsWith(searchTerm);
            
            const matchesDepartment = !selectedDepartment || courseDepartment === selectedDepartment;
            
            if (matchesSearch && matchesDepartment) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        updateResultsCount();
    }

    // Update results count
    function updateResultsCount() {
        const visibleCards = document.querySelectorAll('[data-course]:not([style*="display: none"])');
        const totalCards = courseCards.length;
        const resultsElement = document.querySelector('.results-count');
        if (resultsElement) {
            resultsElement.textContent = `Showing ${visibleCards.length} of ${totalCards} courses`;
        }
    }

    // Search input event
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(performSearch, 300);
    });

    // Department select event
    departmentSelect.addEventListener('change', performSearch);

    // Search suggestions
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();
        
        if (query.length < 2) {
            suggestionsDiv.classList.add('hidden');
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`{{ route('courses.suggestions') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(suggestions => {
                    suggestionsDiv.innerHTML = '';
                    
                    if (suggestions.length > 0) {
                        suggestions.forEach(suggestion => {
                            const div = document.createElement('div');
                            div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                            div.textContent = suggestion.text;
                            div.addEventListener('click', () => {
                                // Extract just the course name from the suggestion
                                const parts = suggestion.text.split(' - ');
                                const courseName = parts.length > 1 ? parts[1].split(' (')[0] : suggestion.text;
                                searchInput.value = courseName;
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