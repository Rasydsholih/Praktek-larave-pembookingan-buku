@extends('layout')

@section('content')
<div class="container d-flex justify-content-center mt-100 mb-100">
    <div class="row"></div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Data Riwayat<br><small class="text-muted">peminjaman</small></h4>
                    <div>
                        <a href="{{route('book.index')}}" class="btn btn-primary">kembali</a>
                    </div>
                    </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penerbit</th>
                                <th>Nama Penulis</th>
                                <th>Judul</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $index => $book)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $book->penerbit }}</td>
                                        <td>{{ $book->penulis }}</td>
                                        <td>{{ $book->judul }}</td>
                                        <td>{{ $book->stock }}</td>
                                        <td>
                                            <form action="{{route('book.restore', $book['id'])}}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Pulihkan</button>
                                            </form>
                                            <form action="{{route('book.forcedelete', $book['id'])}}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus Permanent</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection