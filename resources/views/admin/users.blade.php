@extends('layout.layout')

@section('title')
Users
@endsection

@section('content')

@if(session('message'))
  <div x-data="{ open: true }">
    <x-modal>
        <p class="header-3">{{ session('message') }}</p>
    </x-modal>
  </div>
@endif


<div>
    <p class="header-1">Users</p>
    <div x-data="{ open: false }">
        <button @click="open = true" class="button-secondary">Create User</button>
        <x-modal>
            <p class="header-2">Create New User</p>
            <form method="POST" action="{{ route('create_user') }}" x-data="{ open: true, loading: false }">
                @csrf
                <div x-show="open">
                    <p class="input-label">Employee Information:</p>
                    <div class="flex flex-row">
                        <input type="text" name="username" placeholder="Username" class="input-field m-1">
                        <input type="text" name="email" placeholder="Email" class="input-field m-1">
                    </div>
                    <div class="flex flex-row mb-3">
                        <select name="department" class="input-field m-1">
                            @foreach($departments as $department)
                                <option value={{ $department->id }}>{{ $department->department_description }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="position" placeholder="Position" class="input-field m-1">
                        <select name="role" class="input-field m-1">
                            <option>L1</option>
                            <option>L2</option>
                            <option>L3</option>
                            <option>L4</option>
                        </select>
                    </div>
            
                    <p class="input-label">Personal Information:</p>
                    <div class="flex flex-row mb-3">
                        <input type="text" name="fname" placeholder="First Name" class="input-field m-1">
                        <input type="text" name="mname" placeholder="Middle Name" class="input-field m-1">
                        <input type="text" name="lname" placeholder="Last Name" class="input-field m-1">
                    </div>
            
                    <p class="input-label">Enter New Password:</p>
                    <div class="flex flex-row">
                        <input type="password" name="password" placeholder="Password" class="input-field m-1">
                        <input type="password" name="c_password" placeholder="Confirm Password" class="input-field m-1">
                    </div>
                    <div class="modal-buttons">
                        <button @click="open = false; loading = true" class="button-primary">Create User</button>
                    </div>
                </div>
                <div x-show="loading" x-cloak class="modal-content">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                </div>
            </form>
        </x-modal>
    </div>
    <div class="screen">
        <table class="table">
            <thead>
                <tr class="table-header-row">
                    <td class="table-header">Username</td>
                    <td class="table-header">Employee ID</td>
                    <td class="table-header">Department</td>
                    <td class="table-header">Failed Login Attempts</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="table-row">
                        <td class="table-row-data">{{ $user->username }}</td>
                        <td class="table-row-data">{{ $user->emp_id }}</td>
                        <td class="table-row-data">{{ $user->department_description }}</td>
                        <td class="table-row-data">{{ $user->status != 0 ? $user->failed_login_attempts : "Locked" }}</td>
                        <td class="table-row-data">
                            <div x-data="{ open: false }">
                                <button @click="open = true" class="button-primary">View User</button>
                                <x-modal>
                                    <p class="header-2">User Info</p>
                                    <form method="POST" action="{{ route('update_user', $user->id) }}" x-data="{ open: true, loading: false }">
                                        @csrf
                                        @METHOD('PUT')
                                        <div x-show="open">
                                            <p class="input-label">Employee Information:</p>
                                            <div class="flex flex-row">
                                                <input type="text" name="username" value="{{ $user->username }}" placeholder="Username" class="input-field m-1">
                                                <input type="text" name="email" value="{{ $user->email }}" placeholder="Email" class="input-field m-1">
                                            </div>
                                            <div class="flex flex-row mb-3">
                                                <select name="department" class="input-field m-1">
                                                    @foreach($departments as $department)
                                                        <option value={{ $department->id }} {{ $user->department == $department->id ? 'selected' : '' }}>{{ $department->department_description }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="position" value="{{ $user->position }}" placeholder="Position" class="input-field m-1">
                                                <select name="role" class="input-field m-1">
                                                    <option {{ $user->role == "L1" ? "selected" : "" }}>L1</option>
                                                    <option {{ $user->role == "L2" ? "selected" : "" }}>L2</option>
                                                    <option {{ $user->role == "L3" ? "selected" : "" }}>L3</option>
                                                    <option {{ $user->role == "L4" ? "selected" : "" }}>L4</option>
                                                </select>
                                            </div>

                                            <p class="input-label">Personal Information:</p>
                                            <div class="flex flex-row mb-3">
                                                <input type="text" name="fname" value="{{ $user->fname }}" placeholder="First Name" class="input-field m-1">
                                                <input type="text" name="mname" value="{{ $user->mname }}" placeholder="Middle Name" class="input-field m-1">
                                                <input type="text" name="lname" value="{{ $user->lname }}" placeholder="Last Name" class="input-field m-1">
                                            </div>

                                            <p class="input-label">Enter New Password:</p>
                                            <div class="flex flex-row mb-3">
                                                <input type="password" name="password" placeholder="Password" class="input-field m-1">
                                                <input type="password" name="c_password" placeholder="Confirm Password" class="input-field m-1">
                                            </div>
                                            <div class="modal-buttons">
                                                <button @click="open = false; loading = true" class="button-primary">Update User</button>
                                            </div>
                                        </div>
                                        <div x-show="loading" x-cloak class="modal-content">
                                            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                        </div>
                                    </form>
                                </x-modal>
                            </div>
                            <form method="POST" action="{{ route('lock_unlock_user', $user->id) }}">
                                @csrf
                                @METHOD('PUT')
                                <button class="button-secondary">{{ $user->status == 1 ? 'Lock User' : 'Unlock User' }}</button>
                            </form>
                            <div x-data="{ open: false }">
                                <button type="button" @click="open = true" class="button-danger">Delete User</button>
                                <x-modal>
                                    <p class="header-3">Are you sure to delete user?</p>
                                    <form method="POST" action="{{ route('delete_user', $user->id) }}">
                                        @csrf
                                        @METHOD('DELETE')
                                        <button class="button-danger w-full" @click="open = false">Delete</button>
                                    </form>
                                </x-modal>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection