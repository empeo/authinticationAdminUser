@extends('layouts.app')
@section("title","Admin Dashboard")
@section('content')
    <h1 class="text-center alert alert-dark text-bg-danger mt-5">Hey {{auth()->user()->name}} You Are in Dashboard</h1>
@endsection
