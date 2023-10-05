@extends('Layout')
@section('content')
<div class="container center-page">
    <h2 class="auth-row">Profile</h2>
    <div class="auth-row">
        <label for="name">Name: </label>
        <p class="auth-row">{{ Auth::user()->name }}</p>
    </div>
    <div class="auth-row">
        <label for="email">Email Address: </label>
        <p class="auth-row">{{ Auth::user()->email }}</p>
    </div>
</div>
@stop