@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Reports</h1>

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
                        <th>Reporter</th>
                        <th>Type</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->user->name }}</td>
                            <td>
                                @if($report->review_id)
                                    <span class="badge bg-warning">Review</span>
                                @else
                                    <span class="badge bg-info">Comment</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($report->reason, 100) }}</td>
                            <td>
                                <span class="badge bg-{{ $report->status === 'resolved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($report->status === 'pending')
                                    <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Resolve</button>
                                    </form>
                                    <form action="{{ route('admin.reports.delete-content', $report->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete reported content?')">Delete Content</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection 