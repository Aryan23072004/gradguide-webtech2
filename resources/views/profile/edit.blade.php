<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!-- Page content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Display Role Info -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">User Role</h3>
                    <div class="mt-2">
                        <input type="text" value="{{ Auth::user()->role }}" class="block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm" readonly>
                    </div>
                </div>
            </div>

            <!-- Display Assigned Subjects -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your Subjects</h3>
                    <ul class="list-disc pl-5 text-gray-700">
                        @forelse(Auth::user()->subjects as $subject)
                            <li>{{ $subject->name }} ({{ $subject->code }})</li>
                        @empty
                            <li>No subjects assigned.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Update Profile -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
