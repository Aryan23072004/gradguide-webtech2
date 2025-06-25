@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Professors</h1>
    <form method="GET" action="{{ route('professors.index') }}" class="mb-4">
        <input type="text" name="search" placeholder="Search professors..." value="{{ request('search') }}" class="form-control w-50 d-inline-block">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Average Rating</th>
                <th>Total Reviews</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professors as $professor)
                <tr>
                    <td>{{ $professor->name }}</td>
                    <td>{{ $professor->department }}</td>
                    <td>{{ number_format($professor->reviews()->avg('rating'), 1) ?? 'N/A' }}</td>
                    <td>{{ $professor->reviews()->count() }}</td>
                    <td><a href="{{ route('professors.show', $professor->id) }}" class="btn btn-info btn-sm">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $professors->links() }}
</div>
@endsection 