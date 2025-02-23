@extends('layout')


@section('content') 


<form action="{{ route('book.addLibary', $books['id']) }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm">
    @csrf
    @method('PATCH')

    @if (session('error'))
        <div class="alert alert-success mb-4">
            {{ session('error') }}
        </div>
    @endif

        <div class="form-group">
            <label for="peminjam">Nama Peminjam</label>
            <input type="text" class="form-control" id="peminjam" name="peminjam" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="tgl_pinjam">Masukan Tanggal</label>
            <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="dibooking">Booking</option>
                <option value="dipinjam">Pinjam</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection