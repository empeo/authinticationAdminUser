@extends('layouts.app')
@section('title', 'Home User Page')
@section('content')
    @if ($users->isNotEmpty() and $posts->isNotEmpty())
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @if (auth()->user()->role == 'admin')
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
                            </div>
                            <div class="card-footer d-flex justify-content-between align-content-center">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="card-text btn btn-outline-primary btn-lg btn-block">Edit</a>
                                <form action="{{route("posts.destroy", $post->id)}}" method="post">
                                @csrf
                                @method("delete")
                                <button type="submit" class="card-text btn btn-outline-danger btn-lg btn-block">Delete</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
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
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="d-flex justify-content-center align-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <p class="alert alert-info text-center fs-4 my-3">Not users Found Publish Any Thing</p>
    @endif
@endsection
