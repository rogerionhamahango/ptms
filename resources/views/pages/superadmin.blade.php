@extends('layouts.ptms')


@section('content')
    <div class="container">
        <h1>Super Admin Panel</h1>
        <p class="lead text-danger">Welcome <strong>{{ auth()->user()->full_name }}</strong>!</p>

    </div>
    <div class="container">
        <h2>Manage Users</h2>
        <a href="{{route('user')}}" class="btn btn-primary">Create User</a>
    </div>    
@endsection