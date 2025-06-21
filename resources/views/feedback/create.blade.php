<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Feedback') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('feedback.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="message" class="block font-medium">Your Feedback</label>
                    <textarea name="message" id="message" rows="5" class="w-full border rounded p-2" required></textarea>
                </div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
            </form>
        </div>
    </div>
</x-app-layout>
