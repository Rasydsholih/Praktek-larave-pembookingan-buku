@extends('layout')

@section('content')
<div class="container p-4 bg-white shadow rounded" style="max-width: 500px;">
    <a href="{{route('book.index')}}"><button type="button" class="btn-close" aria-label="Close"></button></a>
    <h1>request aja bukunya</h1>
    <form action="{{ route('bookrequest.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="reason">Alasan (Optional)</label>
            <textarea name="reason" class="form-control"></textarea>
        </div>
        <label for="image">Gambar (Optional)</label>
            <input type="file" name="image" class="form-control">
            <br>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary w-100">Kirim</button>
            </div>

        </div>
       
    </form>
</div>
@endsection