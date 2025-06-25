<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GradGuide - Student Course & Professor Reviews</title>

        <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
            <style>
        body { font-family: 'Inter', sans-serif; }
            </style>
    </head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">GradGuide</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Courses
                    </a>
                    <a href="{{ route('professors.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Professors
                    </a>
                    <a href="{{ route('reviews.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Reviews
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 px-3 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
                </nav>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Find Your Perfect Course
                </h1>
                <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
                    Discover the best courses and professors based on real student experiences.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('reviews.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-md text-lg font-medium hover:bg-gray-100">
                            Write a Review
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded-md text-lg font-medium hover:bg-gray-100">
                            Get Started Free
                        </a>
                    @endauth
                    <a href="{{ route('courses.index') }}" class="border-2 border-white text-white px-6 py-3 rounded-md text-lg font-medium hover:bg-white hover:text-blue-600">
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose GradGuide?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Join thousands of students who trust GradGuide
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Real Student Reviews</h3>
                    <p class="text-gray-600">Get authentic feedback from students who have taken the courses.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Detailed Ratings</h3>
                    <p class="text-gray-600">View comprehensive ratings and difficulty levels.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Community Driven</h3>
                    <p class="text-gray-600">Join a community of students sharing insights.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sign Up Section -->
    @guest
    <section class="py-16 bg-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Join thousands of students who are already using GradGuide to make informed decisions about their courses and professors.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-blue-700">
                        Sign Up Now
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-3 rounded-md text-lg font-medium hover:bg-blue-600 hover:text-white">
                        Already have an account? Login
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endguest

    <!-- Quick Actions -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Explore?</h2>
                <p class="text-lg text-gray-600">Start discovering today</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('courses.index') }}" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Browse Courses</h3>
                    <p class="text-gray-600 text-sm">Find courses by department and rating</p>
                </a>
                
                <a href="{{ route('professors.index') }}" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chalkboard-teacher text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Find Professors</h3>
                    <p class="text-gray-600 text-sm">Discover professors and teaching styles</p>
                </a>
                
                <a href="{{ route('reviews.index') }}" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-yellow-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Read Reviews</h3>
                    <p class="text-gray-600 text-sm">See what other students are saying</p>
                </a>
                
                @auth
                    <a href="{{ route('reviews.create') }}" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-plus text-purple-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Write Review</h3>
                        <p class="text-gray-600 text-sm">Share your experience</p>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-plus text-purple-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Join Community</h3>
                        <p class="text-gray-600 text-sm">Sign up to start contributing</p>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold">GradGuide</span>
                </div>
                <p class="text-gray-400 mb-4">Your trusted platform for course and professor reviews</p>
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} GradGuide. Made for students.</p>
            </div>
        </div>
    </footer>
    </body>
</html>