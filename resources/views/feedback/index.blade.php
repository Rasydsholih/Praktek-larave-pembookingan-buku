@extends('layout')

@section('content')
<div class="container">
    <h1>Book Requests</h1>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>   
        </thead>
        <tbody>
        @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->user->name ?? 'N/A' }}</td>
                    <td>{{ $feedback->user->email ?? 'N/A' }}</td>
                    <td> {{$feedback->message }}</td>
                    <td>{{ $feedback->created_at->format('d M Y') }}</td>
                    <td>
                        <form id="delete-form-{{ $feedback->id }}" action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="confirmDelete({{ $feedback->id }})" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection

@push('js')
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this feedback?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush