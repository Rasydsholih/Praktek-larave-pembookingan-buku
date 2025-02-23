@extends('layout')

@section('content')
    <div class="container p-4 bg-white shadow rounded" style="max-width: 500px;">
        <a href="{{route('book.index')}}"><button type="button" class="btn-close" aria-label="Close"></button></a>
        <h2 class="text-center mb-4">Feedback Form</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary ">Submit Feedback</button>
        </form>
    </div>
@endsection

