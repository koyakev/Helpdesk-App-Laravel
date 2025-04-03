@extends('layout.layout')

@section('title')
Signup
@endsection

@section('content')

<div class="flex flex-col my-6 justify-center items-center">
    <div class="p-6 shadow-lg shadow-green-400 rounded-lg">
        @if(session('message'))
            <p>{{ session('message') }}</p>
        @endif
        <p class="text-4xl my-4">Signup</p>
        <form method="POST" action="{{ route('signup') }}">
            @csrf
            <p class="w-full text-left">Employee Information:</p>
            <div class="flex flex-row">
                <input type="text" name="username" placeholder="Username" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                <input type="text" name="email" placeholder="Email" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
            </div>
            <div class="flex flex-row">
                <select name="department" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                    @foreach($departments as $department)
                        <option>{{ $department->department_description }}</option>
                    @endforeach
                </select>
                <input type="text" name="position" placeholder="Position" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                <select name="role" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                    <option>L1</option>
                    <option>L2</option>
                    <option>L3</option>
                    <option>L4</option>
                </select>
            </div>
    
            <p class="w-full text-left mt-5">Personal Information:</p>
            <div class="flex flex-row">
                <input type="text" name="fname" placeholder="First Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                <input type="text" name="mname" placeholder="Middle Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                <input type="text" name="lname" placeholder="Last Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
            </div>
    
            <p class="w-full text-left mt-5">Enter New Password:</p>
            <div class="flex flex-row">
                <input type="password" name="password" placeholder="Password" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                <input type="password" name="c_password" placeholder="Confirm Password" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
            </div>
            <button class="w-full text-center p-2 bg-green-300 my-2 rounded-lg">Create User</button>
        </form>
        <a href="{{ route('login_form') }}" class="block w-full text-center p-2 border border-green-500 my-2 rounded-md">Login</a>
    </div>
</div>

@endsection