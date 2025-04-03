@extends('layout.layout')

@section('title')
Departments
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
    <p class="text-5xl mb-6 w-auto">Departments</p>
    <div x-data="{ open: false }">
        <button @click="open = true" class="text-center align-center max-w-50 p-1 px-3 bg-yellow-400 text-white font-bold border rounded-full hover:bg-green-300">Create Department</button>
        <div x-show="open" x-cloak class="absolute top-0 left-0 w-full h-screen flex justify-center items-center">
            <div class="absolute h-screen w-full bg-black opacity-50"></div>
            <div class="absolute w-1/3 h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
                <div class="flex w-full justify-end p-1">
                    <button @click="open = false">
                        <i class="fa fa-times-circle text-green-900" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="w-full text-center">
                    <p class="text-2xl">Create New Department</p>
                </div>
                <div class="p-6">
                    <form method="POST" action={{ route('create_department') }}>
                        @csrf
                        <input type="text" name="department_description" placeholder="Department Description" class="border border-green-700 rounded-md p-2 w-full my-3">
                        <input type="text" name="department_code" placeholder="Department Code" class="border border-green-700 rounded-md p-2 w-full my-3">
                        <div class="my-4 w-full justify-end">
                          <div x-data="{ open: false }">
                            <button @click="open = true" class="bg-green-600 text-white p-2 w-1/3 rounded-full">Create Department</button>
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
                    <td class="p-2 text-white font-bold">Department Description</td>
                    <td class="p-2 text-white font-bold">Department Code</td>
                    <td class="p-2 text-white font-bold">Manager ID</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                
                @foreach($departments as $department)
                    <tr class="odd:bg-green-100">
                        <td class="p-2 w-1/4">{{ $department->department_description }}</td>
                        <td class="p-2 w-1/4">{{ $department->department_code }}</td>
                        <td class="p-2 w-1/4">{{ $department->fname }} {{ $department->mname }} {{ $department->lname }}</td>
                        <td>
                            <div x-data="{ open: false }">
                                <button @click="open = true" class="bg-green-900 p-1 px-3 rounded-full text-white">View</button>
                                <div x-show="open" x-cloak class="absolute top-0 left-0 h-screen w-full flex justify-center items-center">
                                    <div class="absolute flex h-screen w-full bg-black opacity-50"></div>
                                    <div class="absolute w-1/3 h-auto bg-white shadow-sm shadow-green-400 rounded-xl p-3">
                                        <div class="flex w-full justify-end p-1">
                                            <button @click="open = false">
                                                <i class="fa fa-times-circle text-green-900" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="w-full text-center">
                                            <p class="text-2xl">Create New Department</p>
                                        </div>
                                        <div class="p-6">
                                            <form method="POST" action={{ route('update_department', $department->id) }}>
                                                @csrf
                                                @METHOD('PUT')
                                                <input type="text" name="department_description" value="{{ $department->department_description }}" placeholder="Department Description" class="border border-green-700 rounded-md p-2 w-full my-3">
                                                <input type="text" name="department_code" value="{{ $department->department_code }}" placeholder="Department Code" class="border border-green-700 rounded-md p-2 w-full my-3">
                                                <select name="manager_id" placeholder="Manager ID" class="border border-green-700 rounded-md p-2 w-full my-3">
                                                    @foreach($employees as $employee)
                                                        @if($department->id == $employee->department && $employee->role == 'L3')
                                                            <option value={{ $employee->id }}>{{ $employee->fname }} {{ $employee->lname }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="my-4 w-full justify-end">
                                                <div x-data="{ open: false }">
                                                    <button @click="open = true" class="bg-green-600 text-white p-2 w-1/3 rounded-full">Edit Department</button>
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection