@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Reports</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($reports->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $reports->links() }}
            @else
                <p>You haven't submitted any reports yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection 