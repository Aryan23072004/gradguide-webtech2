@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-red-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Admin Dashboard</h1>
                <p class="text-red-100">Manage users, reviews, and content moderation</p>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Reviews</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalReviews }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending Reports</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingReports }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-red-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Comments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalComments }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comment text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Manage Users</h3>
                    <p class="text-gray-600 text-sm">View and manage user accounts</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.reviews.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Manage Reviews</h3>
                    <p class="text-gray-600 text-sm">Moderate and manage reviews</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.comments.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-comment text-green-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Manage Comments</h3>
                    <p class="text-gray-600 text-sm">Moderate user comments</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.reports.index') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-flag text-red-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">View Reports</h3>
                    <p class="text-gray-600 text-sm">Handle user reports</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                @foreach($recentActivity as $activity)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-{{ $activity['icon'] }} text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 