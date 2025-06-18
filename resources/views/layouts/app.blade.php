<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'GradGuide') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div>
            <a href="{{ url('/') }}" class="text-lg font-bold">GradGuide</a>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-sm">Role: <strong>{{ Auth::user()->role }}</strong></span>
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
            @endguest
        </div>
    </nav>

    <!-- Page Content -->
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
