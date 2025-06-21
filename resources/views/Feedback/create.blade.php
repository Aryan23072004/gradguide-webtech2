<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Feedback') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow border">
            @if (session('success'))
                <div style="background-color:#d1fae5; color:#065f46; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('feedback.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="message" style="font-weight: 600; display: block; margin-bottom: 5px;">
                        Your Feedback
                    </label>
                    <textarea
                        name="message"
                        id="message"
                        rows="5"
                        style="width: 100%; border: 1px solid #ccc; padding: 10px; border-radius: 4px;"
                        required
                    ></textarea>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        style="background-color:#2563eb; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
