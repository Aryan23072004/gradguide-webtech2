@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Users</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Reviews Count</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'mentor' ? 'warning' : 'primary') }}">{{ $user->role }}</span></td>
                            <td>{{ $user->reviews_count }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection 