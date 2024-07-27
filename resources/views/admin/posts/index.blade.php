@extends('layouts.app')
@section('title', "User's Posts Page")
@section('content')
    @if ($users->isNotEmpty() && $users->pluck('posts')->flatten()->isNotEmpty())
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($users as $user)
                @foreach ($user->posts as $post)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('assets/posts/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ $post->description }}</p>
                            </div>
                            <div class="card-footer">
                                <p class="card-text">{{ $user->name }}</p>
                                <p class="card-text">{{ $user->phone }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-primary">View Post</a>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-success">Edit Post</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <p class="mt-3 text-center">
            <form action="{{ route('posts.clear') }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger">Clear Posts</button>
            </form>
        </p>
        <div class="d-flex justify-content-center align-content-center">
            {{ $users->links() }}
        </div>
    @else
        <p class="alert alert-info text-center fs-4 my-3">No posts found published.</p>
    @endif
@endsection
        