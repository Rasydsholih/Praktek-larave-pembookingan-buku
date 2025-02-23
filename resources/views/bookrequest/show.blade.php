@extends('layout')

@section('content')
<div class="container">
    <h1>Book Request Details</h1>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover earning-box">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Image</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookRequests as $bookRequest)
                        <tr>
                            <td>{{ $bookRequest->title }}</td>
                            <td>{{ $bookRequest->author }}</td>
                            <td>
                                @if($bookRequest->image)
                                    <img src="{{ asset('storage/' . $bookRequest->image) }}" alt="Book Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;" data-toggle="modal" data-target="#imageModal{{ $bookRequest->id }}">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ ucfirst($bookRequest->status) }}</td>
                        </tr>
                        <div class="modal fade" id="imageModal{{ $bookRequest->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $bookRequest->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $bookRequest->id }}">Image Detail</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('storage/' . $bookRequest->image) }}" alt="Book Image" style="width: 100%; height: auto;">
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
    </div>
    <a href="{{ route('book.index') }}" class="btn btn-primary mt-3">Kembali</a>
</div>
@endsection