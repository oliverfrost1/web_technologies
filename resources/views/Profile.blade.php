@extends('Layout')

@section('content')
    <div class="center-page">
        <h2>Profile Settings</h2>
        <h4>
            Profile created on: {{ Auth::user()->created_at->format('j F Y') }}
        </h4>
        <form method="POST" action="{{ route('Profile.update') }}">
            @csrf
            @method('PUT')
            <div class="input-row-container">
                <label>Name:</label>
                <input class="text-input-container" type="text" name="name" value="{{ Auth::user()->name }}">
            </div>
            <div class="input-row-container">
                <label>Email Address:</label>
                <input class="text-input-container" type="email" name="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="input-row-container">
                <label>Current Password:</label>
                <input class="text-input-container" type="password" name="current_password">
            </div>
            <div class="input-row-container">
                <label>New Password:</label>
                <input class="text-input-container" type="password" name="new_password">
            </div>
            <div class="input-row-container">
                <label>Confirm New Password:</label>
                <input class="text-input-container" type="password" name="confirm_new_password">
            </div>
            <div class="center-children-in-parent">
                <button class="todo-button" type="submit">Update Profile</button>
            </div>
        </form>

        @if (session('success'))
            <div class="feedback-message success-message">{{ session('success') }}</div>
        @endif

        @if (session('info'))
            <div class="feedback-message info-message">{{ session('info') }}</div>
        @endif

        @if ($errors->any())
            <div class="feedback-message error-message">{{ $errors->first() }}</div>
        @endif

    </div>
@stop
