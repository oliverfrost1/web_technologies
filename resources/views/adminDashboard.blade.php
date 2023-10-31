@extends('Layout')

@section('content')
<div class="container center-page">
    <h2>Admin Dashboard</h2>
    <h3>Users:</h3>
    <table class="admin-page-table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('j F Y') }}</td>
            <td><a href="{{ route('admin.edit-user', ['id' => $user->id]) }}" class="btn btn-primary">Edit</a></td>
            <td><a href="{{ route('admin.delete-user', ['id' => $user->id]) }}" class="btn btn-danger">Delete</a></td>
        </tr>
        </li>
        @endforeach
        </ul>
</div>
@stop