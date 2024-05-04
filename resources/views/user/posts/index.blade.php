@extends('layouts.app')
@section('title', 'My Posts Page')
@section('content')
        <p class="mt-3 text-center">
            <a href="{{ route('post.create') }}" class="btn btn-success">Create New Post</a>
        </p>
        @if ($posts->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('assets/posts/' . $post->image) }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ $post->description }}</p>
                            </div>
                            <div class="card-footer">
                                <p class="card-text">{{ $post->user->name }}</p>
                                <p class="card-text">{{ $post->user->phone }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary">View Post</a>
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-outline-success">Edit Post</a>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method("delete")
                                        <button type="submit" class="btn btn-outline-danger flex-grow-1">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="alert alert-info text-center fs-4 my-3">No posts found that you published.</p>
        @endif
@endsection
