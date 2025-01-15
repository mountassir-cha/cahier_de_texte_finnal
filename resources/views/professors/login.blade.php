@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('professor.login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login as Professor</button>
    </form>
@endsection 