@extends('Layout')

@section('content')
<div class="container center-page">

    <h2>Login</h2>
    <form action="{{ route('Login') }}" method="POST">
        @csrf

        <label for="email">Email:</label>
        <input type="email" name="email" required>
        @error('email')
        <p style="color:red;">{{ $message }}</p>
        @enderror

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        @error('password')
        <p style="color:red;">{{ $message }}</p>
        @enderror

        <button type="submit">Login</button>
    </form>
</div>
@stop