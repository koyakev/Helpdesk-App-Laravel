@extends('layout.layout')

@section('title')
Users
@endsection

@section('content')

@if(session('message'))
  <div x-data="{ open: true }">
    <div x-show="open" x-cloak class="absolute top-0 left-0 w-full h-screen flex justify-center items-center">
      <div class="absolute h-screen w-full bg-black opacity-50"></div>
      <div class="absolute h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
        <h1 class="my-4 text-lg font-bold">{{ session('message') }}</h1>
        <button class="bg-red-700 text-white p-1 px-3 m-1 rounded-full" @click="open = false">Okay</button>
      </div>
    </div>
  </div>
@endif


<div>
    <p class="text-5xl mb-6 w-auto">Users</p>
    <div x-data="{ open: false }">
        <button @click="open = true" class="text-center align-center max-w-50 p-1 px-3 bg-yellow-400 text-white font-bold border rounded-full hover:bg-green-300">Create User</button>
        <div x-show="open" x-cloak class="absolute top-0 left-0 w-full h-screen flex justify-center items-center">
            <div class="absolute h-screen w-full bg-black opacity-50"></div>
            <div class="absolute w-1/2 h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
                <div class="flex w-full justify-end p-1">
                    <button @click="open = false">
                        <i class="fa fa-times-circle text-green-900" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="w-full text-center">
                    <p class="text-2xl">Create New User</p>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('create_user') }}">
                        @csrf
                        <p class="w-full text-left">Employee Information:</p>
                        <div class="flex flex-row">
                            <input type="text" name="username" placeholder="Username" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                            <input type="text" name="email" placeholder="Email" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                        </div>
                        <div class="flex flex-row">
                            <select name="department" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                @foreach($departments as $department)
                                    <option value={{ $department->id }}>{{ $department->department_description }}</option>
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
                        <div class="my-4 w-full justify-end">
                            <div x-data="{ open: false }">
                                <button @click="open = true" class="bg-green-600 text-white p-2 w-1/3 rounded-full">Create User</button>
                                <div x-show="open" x-cloak class="fixed inset-0 bg-black opacity-50 flex justify-center items-center">
                                    <i class="fa fa-spinner fa-spin fa-3x fa-fw text-white"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="my-6 w-full">
        <table class="w-full">
            <thead>
                <tr class="bg-green-600">
                    <td class="p-2 text-white font-bold">Username</td>
                    <td class="p-2 text-white font-bold">Employee ID</td>
                    <td class="p-2 text-white font-bold">Department</td>
                    <td class="p-2 text-white font-bold">Failed Login Attempts</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="odd:bg-green-100">
                        <td class="p-2 w-1/5">{{ $user->username }}</td>
                        <td class="p-2 w-1/5">{{ $user->emp_id }}</td>
                        <td class="p-2 w-1/5">{{ $user->department_description }}</td>
                        <td class="p-2 w-1/5">{{ $user->status != 0 ? $user->failed_login_attempts : "Locked" }}</td>
                        <td class="p-2 w-1/5 text-center">

                            <div x-data="{ open: false }">
                                <button @click="open = true" class="bg-green-900 p-1 px-3 rounded-full text-white">View</button>
                                <div x-show="open" x-cloak class="absolute top-0 left-0 w-full h-screen flex justify-center items-center">
                                    <div class="absolute h-screen w-full bg-black opacity-50"></div>
                                    <div class="absolute w-1/2 h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
                                        <div class="flex w-full justify-end p-1">
                                            <button @click="open = false">
                                                <i class="fa fa-times-circle text-green-900" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <p class="text-2xl">User Info</p>
                                        <div class="p-6">
                                            <form method="POST" action="{{ route('update_user', $user->id) }}">
                                                @csrf
                                                @METHOD('PUT')
                                                <p class="w-full text-left">Employee Information:</p>
                                                <div class="flex flex-row">
                                                    <input type="text" name="username" value="{{ $user->username }}" placeholder="Username" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                    <input type="text" name="email" value="{{ $user->email }}" placeholder="Email" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                </div>
                                                <div class="flex flex-row">
                                                    <select name="department" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                        @foreach($departments as $department)
                                                            <option value={{ $department->id }} {{ $user->department == $department->id ? 'selected' : '' }}>{{ $department->department_description }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="position" value="{{ $user->position }}" placeholder="Position" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                    <select name="role" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                        <option {{ $user->role == "L1" ? "selected" : "" }}>L1</option>
                                                        <option {{ $user->role == "L2" ? "selected" : "" }}>L2</option>
                                                        <option {{ $user->role == "L3" ? "selected" : "" }}>L3</option>
                                                        <option {{ $user->role == "L4" ? "selected" : "" }}>L4</option>
                                                    </select>
                                                </div>

                                                <p class="w-full text-left mt-5">Personal Information:</p>
                                                <div class="flex flex-row">
                                                    <input type="text" name="fname" value="{{ $user->fname }}" placeholder="First Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                    <input type="text" name="mname" value="{{ $user->mname }}" placeholder="Middle Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                    <input type="text" name="lname" value="{{ $user->lname }}" placeholder="Last Name" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                </div>

                                                <p class="w-full text-left mt-5">Enter New Password:</p>
                                                <div class="flex flex-row">
                                                    <input type="password" name="password" placeholder="Password" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                    <input type="password" name="c_password" placeholder="Confirm Password" class="border border-green-700 rounded-md p-2 m-1 w-full my-3">
                                                </div>
                                                <div class="my-4 flex w-full">
                                                    <div x-data="{ open: false }" class="w-1/4 m-1">
                                                        <button @click="open = true" class="bg-green-400 text-white p-1 w-full rounded-full">Update User</button>
                                                        <div x-show="open" x-cloak class="fixed inset-0 bg-black opacity-50 flex justify-center items-center">
                                                            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="my-4 flex w-full">
                                              <div class="w-1/2 m-1">
                                                <form method="POST" action="{{ route('lock_unlock_user', $user->id) }}">
                                                  @csrf
                                                  @METHOD('PUT')
                                                  <button class="bg-yellow-500 text-white p-1 px-3 w-full rounded-full">{{ $user->status == 1 ? 'Lock User' : 'Unlock User' }}</button>
                                                </form>
                                              </div>
                                              <div x-data="{ open: false }" class="w-1/2 m-1">
                                                <button type="button" @click="open = true" class="bg-red-700 text-white p-1 w-full rounded-full">Delete User</button>
                                                <div x-show="open" x-cloak class="absolute top-0 left-0 w-full h-screen flex justify-center items-center">
                                                  <div class="absolute h-screen w-full bg-black opacity-50"></div>
                                                  <div class="absolute h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
                                                    <h1>Are you sure to delete user?</h1>
                                                    <form method="POST" action="{{ route('delete_user', $user->id) }}">
                                                      @csrf
                                                      @METHOD('DELETE')
                                                      <button class="bg-red-700 text-white p-1 px-3 w-auto rounded-full">Delete</button>
                                                    </form>
                                                    <button type="button" @click="open = false" class="bg-blue-700 text-white p-1 px-3 m-1 w-auto rounded-full">Cancel</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection