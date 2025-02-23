@extends('layout')

@section('content')



<div class="container mt-5">
    <h2>Tambah Buku</h2>
    <form action="{{ route('book.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="penerbit">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stock">stock</label>
            <input type="number" name="stock" id="stock" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection