<!-- resources/views/register.blade.php -->
@extends('Layout')
@section('content')
    <div class="container center-page">
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-row">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }} " class="input-container" required autofocus>
                @error('name')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="auth-row">
                <label for="email">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input-container" required>
            </div>
            <div class="auth-row">
                <label for="password">Password</label>
                <input type="password" name="password" class="input-container" required>
            </div>
            <div class="auth-row">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input-container" required>
            </div>
            <div class="center-children-in-parent">
                <button type="submit" class="todo-button">Register</button>
            </div>
            <div class="error-message">
                @error('name')
                    <span>Name error: {{ $message }}</span>
                @enderror

                @error('email')
                    <span>Email error: {{ $message }}</span>
                @enderror

                @error('password')
                    <span>Password error: {{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
@stop
