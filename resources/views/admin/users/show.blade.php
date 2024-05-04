@extends('layouts.app')
@section('title', 'Show User Information')
@section('content')
    @if (session('error'))
        <div class="alert alert-info my-3">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-info my-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid text-left ">
    </div>
    <div class="card border-primary mb-3 mx-auto" style="max-width: 80rem;">
        <div class="card-header bg-primary text-white fs-2 font-weight-bold">Name: {{ $user->name }}</div>
        <div class="container_image" style="overflow: hidden; width:30%; margin:auto; border-radius: 50%">
            <img class="w-100" src="{{ asset('assets/users/user/' . $user->image) }}" alt="UserImage">
        </div>
        <div class="card-body">
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">email: </span>
                {{ $user->email }}
            </p>
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">phone: </span>
                {{ $user->phone }}
            </p>
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">gender: </span>
                {{ $user->gender }}
            </p>
            <p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back To Home</a>
            </p>
        </div>
    </div>
@endsection
