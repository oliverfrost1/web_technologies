@extends('Layout')
@props(['user'])

@section('content')
<div class="center-page">
    <h2>Edit user id: {{$user->id}}</h2>
    <h4>
        Profile created on: {{ $user->created_at->format('j F Y') }}
    </h4>
    <form method="POST" action="{{ route('admin.edit-user', ['id' => $user->id]) }}">
        @csrf
        <div class="auth-row">
            <label>Name:</label>
            <input class="input-container" type="text" name="name" value="{{ $user->name }}">
        </div>
        <div class="auth-row">
            <label>Email Address:</label>
            <input class="input-container" type="email" name="email" value="{{ $user->email }}">
        </div>
        <div class="auth-row">
            <label>Password:</label>
            <input class="input-container" type="password" name="password" value="{{ $user->password}}">
        </div>
        <div class="center-children-in-parent">
            <button class="todo-button" type="submit">Update User</button>
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