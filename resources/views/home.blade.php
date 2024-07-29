@extends('layouts.app')
@section('title', 'Home User Page')
@section('content')
    @if ($users->isNotEmpty() and $users->pluck('posts')->flatten()->isNotEmpty())
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($users as $user)
                @foreach ($user->posts as $post)
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('assets/posts/' . $post->image) }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ $post->description }}</p>
                            </div>
                            <div class="card-footer">
                                <p class="card-text">{{ $user->name }}</p>
                                <p class="card-text">{{ $user->phone }}</p>
                            </div>
                            @if (auth()->user()->role == 'admin')
                                <div class="card-footer d-flex justify-content-between align-content-center">
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="card-text btn btn-outline-primary btn-lg btn-block">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="card-text btn btn-outline-danger btn-lg btn-block">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <div class="d-flex justify-content-center align-content-center">
            {{ $users->links() }}
        </div>
    @else
        <p class="alert alert-info text-center fs-4 my-3">No users have published anything yet.</p>
    @endif
@endsection
