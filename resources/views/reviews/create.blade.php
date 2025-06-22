<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Review') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf

                <!-- Course Dropdown -->
                <div class="mb-4">
                    <label for="course_id" class="block font-medium text-sm text-gray-700">Course</label>
                    <select name="course_id" id="course_id" class="w-full border rounded p-2">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Professor Dropdown -->
                <div class="mb-4">
                    <label for="professor_id" class="block font-medium text-sm text-gray-700">Professor</label>
                    <select name="professor_id" id="professor_id" class="w-full border rounded p-2">
                        @foreach ($professors as $professor)
                            <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating -->
                <div class="mb-4">
                    <label for="rating" class="block font-medium text-sm text-gray-700">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" class="w-full border rounded p-2" required>
                </div>

                <!-- Review Text -->
                <div class="mb-4">
                    <label for="text" class="block font-medium text-sm text-gray-700">Review</label>
                    <textarea name="text" id="text" rows="4" class="w-full border rounded p-2" required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
