@extends('Layout')

@section('content')
    <div class="container center-page">

        <h2>Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-row-container">
                <label for="email">Email:</label>
                <input type="email" name="email" required class="text-input-container">
            </div>
            @error('credential')
                <p class="error-message">{{ $message }}</p>
            @enderror
            <div class="input-row-container">
                <label for="password">Password:</label>
                <input type="password" name="password" required class="text-input-container">
            </div>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <div class="center-children-in-parent">
                <button type="submit" class="todo-button">Login</button>
            </div>
        </form>
    </div>
@stop
