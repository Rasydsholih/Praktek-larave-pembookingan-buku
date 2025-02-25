@extends('layout')

@section('content')
<div class="container mt-5">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Konfirmasi Pengembalian Buku</h2>
    <p>Buku <strong>{{ $book->judul }}</strong> berhasil dikembalikan.</p>
    <p>Apakah Anda ingin memberikan feedback untuk buku ini?</p>

    <div class="mt-4">
        <a href="{{ route('feedback.create', $book->id) }}" class="btn btn-primary">Ya, Berikan Feedback</a>
        <a href="{{ route('book.index') }}" class="btn btn-secondary">Tidak, Kembali ke Daftar Buku</a>
    </div>
</div>
@endsection