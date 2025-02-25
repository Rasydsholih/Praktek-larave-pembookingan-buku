@extends('layout')

@push('css')
<style>
    /* Gaya global */
body {
    background: #f4f6f9;
    font-family: 'Poppins', sans-serif;
}

/* Card utama */
.feedback-card {
    max-width: 500px;
    background: #fff;
    margin: 50px auto;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Judul */
.title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
}

.subtitle {
    font-size: 18px;
    color: #777;
    margin-bottom: 20px;
}

/* Input group */
.input-group {
    text-align: left;
    margin-bottom: 15px;
}

.input-group label {
    font-size: 14px;
    font-weight: 500;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.input-group textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    outline: none;
    resize: none;
    transition: all 0.3s ease-in-out;
}

.input-group textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
}

/* Tombol submit */
.btn-submit {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    color: white;
    font-size: 16px;
    font-weight: 500;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-submit:hover {
    backgro

</style>
@endpush
@section('content')
<div class="container">
    <div class="feedback-card">
        <h3 class="title">Kirim Feedback untuk Buku</h3>
        <h5 class="subtitle">{{ $book->judul }}</h5>
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <div class="input-group">
                <label for="message">Feedback Anda</label>
                <textarea name="message" id="message" required></textarea>
            </div>
            <button type="submit" class="btn-submit">Kirim Feedback</button>
        </form>
    </div>
</div>
@endsection
