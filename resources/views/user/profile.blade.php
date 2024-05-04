@extends('layouts.app')
@section('title', 'Profile User Page')
@section('content')
    <section style="background-color: #9de2ff; height:80vh">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-9 col-lg-7 col-xl-5">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex text-black">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/users/user/' . $user->image) }}"
                                        alt="Generic placeholder image" class="img-fluid"
                                        style="width: 180px; border-radius: 10px;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Name: {{ $user->name }}</h5>
                                    <p class="mb-2 pb-1" style="color: #2b2a2a;">Email: {{ $user->email }}</p>
                                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                                        style="background-color: #efefef;">
                                        <div>
                                            <p class="small text-muted mb-1">Phone</p>
                                            <p class="mb-0">{{ $user->phone }}</p>
                                        </div>
                                        <div class="px-3">
                                            <p class="small text-muted mb-1">Gender</p>
                                            <p class="mb-0">{{ $user->gender }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex pt-1">
                                        <a href="{{route("user.edit",$user->id)}}" class="btn btn-outline-primary me-1 flex-grow-1">Update</a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method("delete")
                                            <button type="submit" class="btn btn-outline-danger flex-grow-1">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
