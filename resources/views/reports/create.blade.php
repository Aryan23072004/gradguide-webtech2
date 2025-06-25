@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Report {{ ucfirst($type) }}</h1>

    <div class="card">
        <div class="card-body">
            <h5>Content being reported:</h5>
            @if($type === 'review')
                <div class="border p-3 mb-3">
                    <strong>{{ $content->course->name }} - {{ $content->professor->name }}</strong><br>
                    <small class="text-muted">By {{ $content->user->name }} on {{ $content->created_at->format('M d, Y') }}</small><br>
                    <span class="badge bg-primary">Rating: {{ $content->rating }}/5</span><br>
                    <p class="mt-2">{{ $content->text }}</p>
                </div>
            @else
                <div class="border p-3 mb-3">
                    <strong>{{ $content->user->name }}</strong><br>
                    <small class="text-muted">{{ $content->created_at->format('M d, Y') }}</small><br>
                    <p class="mt-2">{{ $content->text }}</p>
                </div>
            @endif

            <form action="{{ route('reports.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="content_id" value="{{ $id }}">
                
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for reporting:</label>
                    <textarea name="reason" id="reason" class="form-control" rows="4" required maxlength="500" placeholder="Please explain why you are reporting this content..."></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 