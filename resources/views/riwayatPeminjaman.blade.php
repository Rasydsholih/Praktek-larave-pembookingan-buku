@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Riwayat Peminjaman Buku</h2>
    <a href="{{ route('book.index') }}">
        <button class="btn btn-primary mb-3">Kembali</button>
    </a>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover earning-box">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $history->book->judul }}</td> <!-- Perbaikan di sini -->
                        <td>{{ $history->tgl_pinjam }}</td>
                        <td>{{ $history->tgl_kembali }}</td>
                        <td>{{ $history->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection