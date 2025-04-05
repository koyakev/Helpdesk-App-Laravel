@extends('layout.layout')

@section('title')
Departments
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
    <p class="header-1">Departments</p>
    <div x-data="{ open: false }">
        <button @click="open = true" class="button-secondary">Create Department</button>
        <x-modal>
            <p class="header-2">Create New Department</p>
            <form method="POST" action={{ route('create_department') }} x-data="{ loading: false, open: true }">
                @csrf
                <div x-show="open">
                    <input type="text" name="department_description" placeholder="Department Description" class="input-field">
                    <input type="text" name="department_code" placeholder="Department Code" class="input-field">
                    <div class="modal-buttons">
                        <button @click="loading = true; open = false" class="button-primary">Create Department</button>
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
                    <td class="table-header">Department Description</td>
                    <td class="table-header">Department Code</td>
                    <td class="table-header">Manager ID</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                
                @foreach($departments as $department)
                    <tr class="table-row">
                        <td class="table-row-data">{{ $department->department_description }}</td>
                        <td class="table-row-data">{{ $department->department_code }}</td>
                        <td class="table-row-data">{{ $department->fname }} {{ $department->mname }} {{ $department->lname }}</td>
                        <td class="table-row-data">
                            <div x-data="{ open: false }">
                                <button @click="open = true" class="button-primary">View</button>
                                <x-modal>
                                    <p class="header-2 my-2">Update Department</p>
                                    <form method="POST" action={{ route('update_department', $department->id) }} x-data="{ open: true, loading: false }">
                                        @csrf
                                        @METHOD('PUT')
                                        <div x-show="open">
                                            <input type="text" name="department_description" value="{{ $department->department_description }}" placeholder="Department Description" class="input-field">
                                            <input type="text" name="department_code" value="{{ $department->department_code }}" placeholder="Department Code" class="input-field">
                                            <select name="manager_id" placeholder="Manager ID" class="input-field">
                                                @foreach($employees as $employee)
                                                    @if($department->id == $employee->department && $employee->role == 'L3' || $employee->role == 'L4')
                                                        <option value={{ $employee->id }}>{{ $employee->fname }} {{ $employee->lname }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="modal-buttons">
                                                <button @click="open = false; loading = true" class="button-primary">Update Department</button>
                                            </div>
                                        </div>
                                        <div x-show="loading" x-cloak class="modal-content">
                                            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                                        </div>
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