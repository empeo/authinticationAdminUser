@extends('layouts.app')
@section('title', 'Show Page Post')
@section('content')
    @if (session('error'))
        <div class="alert alert-info my-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid text-left ">
    </div>
    <div class="card border-primary mb-3 mx-auto" style="max-width: 80rem;">
        <div class="card-header bg-primary text-white fs-2 font-weight-bold">Title: {{ $post->title }}</div>
        <div class="container_image" style="overflow: hidden; width:30%; margin:auto; border-radius: 50%">
            <img class="w-100" src="{{ asset('assets/posts/' . $post->image) }}" alt="UserImage">
        </div>
        <div class="card-body">
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">owner email: </span>
                {{ $post->user->email }}
            </p>
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">owner phone: </span>
                {{ $post->user->phone }}
            </p>
            <p class="card-text fs-2"><span class="font-weight-bolder text-capitalize text-danger">description: </span>
                {{ $post->description }}
            </p>
            <p class="card-text fs-2">
                <a href="{{ route('posts.index') }}" class="btn btn-primary">Back To Home</a>
            </p>
        </div>
    </div>
@endsection
