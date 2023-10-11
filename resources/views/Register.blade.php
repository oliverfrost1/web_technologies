<!-- resources/views/register.blade.php -->

@extends('Layout')
@section('content')
<div class="container center-page">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="auth-row">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
            <span>{{ $message }}</span>
            @enderror
        </div>
        <div class="auth-row">
            <label for="email">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <span>{{ $message }}</span>
            @enderror
        </div>
        <div class="auth-row">
            <label for="password">Password</label>
            <input type="password" name="password" required>
            @error('password')
            <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-row">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit" class="button">Register</button>
        </div>
    </form>
</div>
@stop