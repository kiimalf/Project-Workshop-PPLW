@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="text" name="otp" maxlength="6" required>
        <button type="submit">Verifikasi</button>
    </form>
@endsection