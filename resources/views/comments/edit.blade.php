@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Comment</h1>
    
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="text" class="form-label">Comment Text</label>
            <textarea name="text" id="text" class="form-control" rows="3" required maxlength="500">{{ $comment->text }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Comment</button>
            <a href="{{ route('reviews.show', $comment->review_id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection 