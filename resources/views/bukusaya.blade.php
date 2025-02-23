@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Daftar Buku Saya</h2>
    <a href="{{ route('book.index') }}">
        <button class="btn btn-primary mb-3">Kembali</button>
    </a>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover earning-box">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Penerbit</th>
                        <th>Nama Penulis</th>
                        <th>Judul</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Pinjam & status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->penerbit }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->peminjam }}</td>
                        <td>
                            @if($book->status === 'dibooking' || $book->status === 'dipinjam')
                               {{ $book->tgl_pinjam ?? 'Belum ditentukan' }}
                            @elseif($book->status === 'dikembalikan')
                                Tanggal Kembali: {{ $book->tgl_kembali }}
                            @endif
                            : {{ $book->status }}
                        </td>
                        <td>
                            @if($book->status === 'dipinjam' && $book->peminjam === auth()->user()->name)
                            <form action="{{ route('book.return', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Kembalikan buku</button>
                            </form>
                            @elseif($book->status === 'dibooking' && $book->peminjam === auth()->user()->name)
                            <form action="{{ route('book.StatusDipinjam', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <div class="form-group">
                                    <label for="tgl_pinjam">Tanggal Pinjam</label>
                                    <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Pinjam Buku</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 