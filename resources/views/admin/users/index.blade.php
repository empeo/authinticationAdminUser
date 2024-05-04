@extends('layouts.app')
@section('title', 'Users - Admin Panel')
@section('content')
    <div class="text-center my-4">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create A User</a>
    </div>
    @if (session('success'))
        <div class="alert alert-info">
            {{ session('success') }}
        </div>
    @endif
    @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    @if ($users->isNotEmpty())
        <table class="table text-center table-responsive" id="myTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->gender }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('users.deleteuser', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center align-content-center">
            {{ $users->links() }}
        </div>
        <div class="text-center my-4">
            <form action="{{ route('users.clear') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete All Users?')">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Delete All Users</button>
            </form>
        </div>
    @else
        <div class="alert alert-info text-center" role="alert">
            No users found.
        </div>
    @endif
@endsection
