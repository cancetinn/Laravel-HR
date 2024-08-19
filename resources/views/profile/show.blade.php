@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Profile</h1>
    <div class="card">
        <div class="card-body">
            <img src="{{ $user->profile_image_url }}" alt="Profile Image" width="100">
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Title:</strong> {{ $user->title }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Department:</strong> {{ $user->department_name }}</p>
            <p><strong>Joining Date:</strong> {{ $user->joining_date }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
