<!-- resources/views/register.blade.php -->
@extends('Layout')
@section('content')
    <section class="container center-page">
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-row-container">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }} " class="text-input-container" required
                    autofocus>
                @error('name')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="input-row-container">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="text-input-container" required>
            </div>
            <div class="input-row-container">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="text-input-container" required>
            </div>
            <div class="input-row-container">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="text-input-container" required>
            </div>
            <div class="center-children-in-parent">
                <button id="submit" type="submit" class="todo-button">Register</button>
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
    </section>
@stop
