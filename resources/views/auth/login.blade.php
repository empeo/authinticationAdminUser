@extends('layouts.app')
@section('title', 'Login Page')
@section('content')
    <section class="w-100 d-flex justify-content-center align-items-center" style="height: 80vh">
        <div class="container">
            @if (session('error'))
                <p class="alert alert-danger text-center fs-4">{{ session('error') }}</p>
            @endif
            @if (session('success'))
                <p class="alert alert-info text-center fs-4">{{ session('success') }}</p>
            @endif
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-2-strong" style="border-radius: 2rem;  overflow:hidden">
                        <div class="card-body p-5 text-center" style="background-color: rgba(0, 0, 0, 0.5); color:white">
                            <h3 class="mb-5">Sign in</h3>
                            <form method="post" action="{{ route('login.ensure') }}" class="needs-validation">
                                @csrf
                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typeEmailX-2">Email</label>
                                    <input type="email" id="typeEmailX-2"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" value="{{old("email")}}"/>
                                    @error('email')
                                        <p class="alert alert-danger invalid-feedback my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label my-3 fs-4" for="typePasswordX-2">Password</label>
                                    <input type="password" id="typePasswordX-2"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" value="{{old("password")}}"/>
                                    @error('password')
                                        <p class="alert alert-danger invalid-feedback my-3" style="font-weight:bolder;">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
