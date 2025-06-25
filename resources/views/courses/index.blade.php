@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Courses</h1>
    <form method="GET" action="{{ route('courses.index') }}" class="mb-4">
        <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}" class="form-control w-50 d-inline-block">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Department</th>
                <th>Average Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->code }}</td>
                    <td>{{ $course->department }}</td>
                    <td>{{ number_format($course->reviews()->avg('rating'), 1) ?? 'N/A' }}</td>
                    <td><a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $courses->links() }}
</div>
@endsection 