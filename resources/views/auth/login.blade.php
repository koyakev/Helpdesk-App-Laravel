@extends('layout.layout')

@section('title')
Login
@endsection

@section('content')

<div class="flex flex-col my-6 justify-center items-center">
    <div class="p-6 shadow-lg shadow-green-400 rounded-lg w-sm">
        @if(session('message'))
            <p>{{ session('message') }}</p>
        @endif
        <p class="text-4xl my-4">Login</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" placeholder="Username" name="username" class="border border-green-700 rounded-md p-2 w-full my-3">
            <input type="password" placeholder="********" name="password" class="border border-green-700 rounded-md p-2 w-full my-3">
            <button class="w-full text-center p-2 bg-green-300 my-2 rounded-lg">Login</button>
        </form>
        <a href="{{ route('signup_form') }}" class="block w-full text-center p-2 border border-green-500 my-2 rounded-md">Signup</a>
    </div>
</div>

@endsection