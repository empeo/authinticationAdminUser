@extends('layouts.app')
@section('title', 'Register Page')
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
                            <h3 class="mb-5">Register</h3>
                            <form method="post" action="{{ route('register.ensure') }}" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typeEmailX-2">Name</label>
                                    <input type="text" id="typeEmailX-2"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" />
                                    @error('name')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typeEmailX-2">Email</label>
                                    <input type="email" id="typeEmailX-2"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" />
                                    @error('email')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typePasswordX-2">Password</label>
                                    <input type="password" id="typePasswordX-2"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password"/>
                                    @error('password')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typePasswordXcon-2">Confirm Password</label>
                                    <input type="password" id="typePasswordXcon-2"
                                        class="form-control form-control-lg @error('conipassword') is-invalid @enderror"
                                        name="conipassword"/>
                                    @error('conipassword')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="phone-2">Phone</label>
                                    <input type="phone" id="phone-2"
                                        class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" />
                                    @error('phone')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-center align-items-center gap-3 my-3">
                                    <div class="form-check d-flex justify-content-center align-items-center gap-3">
                                        <input class="form-check-input" type="radio" id="flexRadioDefault1" name="gender"
                                            value="male" @checked(old('gender') == 'male')>
                                        <label class="form-check-label text-capitalize fs-4" for="flexRadioDefault1">
                                            male
                                        </label>
                                    </div>
                                    <div class="form-check d-flex justify-content-center align-items-center gap-3">
                                        <input class="form-check-input" type="radio" id="flexRadioDefault2" name="gender"
                                            value="female" @checked(old('gender') == 'female')>
                                        <label class="form-check-label text-capitalize fs-4" for="flexRadioDefault2">
                                            female
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                <div class="col-12">
                                    <label for="image" class="form-label text-capitalize my-3 fs-4">image</label>
                                    <input type="file" name="image" class="form-control @error("image") is-invalid @enderror" id="image">
                                    @error('image')
                                        <p class="alert alert-danger my-3" style="font-weight:bolder;">
                                            {{ $message  }}
                                        </p>
                                    @enderror
                                </div>

                                <button class="btn btn-primary btn-lg btn-block my-3" style="font-weight: bolder;" type="submit">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
