@extends('layout')

@section('content')
<div class="container">
    <h1>Book Requests</h1>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Alasan</th>
                <th>Gambar</th>
                <th>Status</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->title }}</td>
                    <td>{{ $request->author }}</td>
                    <td>{{ $request->reason }}</td>
                    <td><img src="{{ asset('storage/' . $request->image) }}" alt="Book Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;" data-toggle="modal" data-target="#imageModal{{ $request->id }}"></td>
                    <td>{{ ucfirst($request->status) }}</td>

                    <td>
                    @if($request->status === 'pending')
                        <div class="d-flex gap-2">
                            <form action="{{ route('bookrequest.updateStatus', $request->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('bookrequest.updateStatus', $request->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    @endif
                    </td>
                </tr>
                <div class="modal fade" id="imageModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $request->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $request->id }}">Image Detail</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('storage/' . $request->image) }}" alt="Book Image" style="width: 100%; height: auto;">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection