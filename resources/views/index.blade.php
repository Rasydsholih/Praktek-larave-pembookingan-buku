@extends('layout')

@push('css')
<style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(45deg, #007bff, #00bfff);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-primary {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .table-hover tbody tr {
            transition: background-color 0.3s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .alert {
            margin-top: 20px;
        }
    </style>

@endpush
@section('content')

<div class="container mt-5">
    <h2>Daftar Peminjaman Buku</h2>
    @if(auth()->user()->role === 'admin')
        <a href="{{route('book.create')}}">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDataModal">
            Tambah Data
        </button>
        </a>
    @endif
    @if(auth()->user()->role === 'user')
    <a href="{{Route('book.bukusaya')}}">
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDataModal">
        buku saya
    </button>
    </a>
    @endif
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('book.history') }}">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDataModal">
                <i class="fa-solid fa-clock-rotate-left"></i> history
            </button>
        </a>
    @endif
    @if (session('add'))
        <div class="alert alert-success">
            {{ session('add') }}
        </div>
    @endif
    @if (session('update'))
        <div class="alert alert-success">
            {{ session('update') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('delete'))
        <div class="alert alert-warning">
            {{ session('delete') }}
        </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('Berhasil'))
    <div class="alert alert-danger" role="alert">
            {{ session('Berhasil') }}
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover earning-box" id="books-table">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Penerbit</th>
                        <th>Nama Penulis</th>
                        <th>Judul</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('js')
<script>
        $(document).ready(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('book.datatable') }}",
                columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false },
                    { data: 'penerbit', name: 'penerbit' },
                    { data: 'penulis', name: 'penulis' },
                    { data: 'judul', name: 'judul' },
                    { data: 'stock', name: 'stock' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'csv'
                ],
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "«",
                        "last": "»",
                        "next": "›",
                        "previous": "‹"
                    },
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri"
                }
            });
        });


</script>
@endpush
@endsection