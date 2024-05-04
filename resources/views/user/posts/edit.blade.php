@extends('layouts.app')
@section('title', 'Edit Page Post')
@section('content')
    <section class="w-100 d-flex justify-content-center align-items-center">
        <div class="container">
            @if (session('error'))
                <p class="alert alert-danger text-center fs-4">{{ session('error') }}</p>
            @endif
            <div class="row justify-content-center">
                <div class="w-100">
                    <div class="card shadow-2-strong" style="border-radius: 2rem;  overflow:hidden">
                        <div class="card-body p-5 text-center" style="background-color: rgba(0, 0, 0, 0.5); color:white">
                            <h3 class="mb-5">Edit Post</h3>
                            <form method="post" action="{{ route('post.update',$post->id) }}" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                @method("put")
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typeEmailX-2">title</label>
                                    <input type="text" id="typeEmailX-2"
                                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title')?old('title'):$post->title }}" />
                                    @error('title')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Description Here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
                                        <label for="floatingTextarea2">Description</label>
                                    </div>
                                    @error('description')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="image" class="form-label text-capitalize my-3 fs-4">image</label>
                                    <input type="file" name="image" class="form-control @error("image") is-invalid @enderror" id="image">
                                    @error('image')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message  }}
                                        </p>
                                    @enderror
                                </div>

                                <button class="btn btn-primary btn-lg btn-block my-3" style="font-weight: bolder;" type="submit">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
