@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h1>
    <p class="mt-2">You are logged in as <strong>{{ Auth::user()->role }}</strong>.</p>
@endsection
