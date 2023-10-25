@extends('Layout')

@section('content')
    <div class="center-page">
        <h2>Profile Settings</h2>
        <h4>
            Profile created on: {{ Auth::user()->created_at->format('j F Y') }}
        </h4>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="auth-row">
                <label>Name:</label>
                <input class="input-container" type="text" name="name" value="{{ Auth::user()->name }}">
            </div>
            <div class="auth-row">
                <label>Email Address:</label>
                <input class="input-container" type="email" name="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="auth-row">
                <label>Current Password:</label>
                <input class="input-container" type="password" name="current_password">
            </div>
            <div class="auth-row">
                <label>New Password:</label>
                <input class="input-container" type="password" name="new_password">
            </div>
            <div class="auth-row">
                <label>Confirm New Password:</label>
                <input class="input-container" type="password" name="confirm_new_password">
            </div>
            <div class="center-children-in-parent">
                <button class="todo-button" type="submit">Update Profile</button>
            </div>
        </form>

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @if (session('info'))
            <div class="info-message">{{ session('info') }}</div>
        @endif

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-message">{{ $errors->first() }}</div>
        @endif

    </div>
@stop
