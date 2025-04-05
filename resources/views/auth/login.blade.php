@extends('layout.layout')

@section('title')
Login
@endsection

@section('content')

@if(session('message')) 
    <div x-data="{ open : true }">
        <x-modal>
            <p class="header-3">{{ session('message') }}</p>
        </x-modal>
    </div>
@endif

<div class="screen">
    <div class="form-sm">
        <p class="header-2">Login</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" placeholder="Username" name="username" class="input-field">
            <input type="password" placeholder="********" name="password" class="input-field">
            <button class="button-primary-1">Login</button>
        </form>
        <a href="{{ route('signup_form') }}" class="link">Signup</a>
    </div>
</div>

@endsection