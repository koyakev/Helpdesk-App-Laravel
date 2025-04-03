<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\Employee;
use App\Models\Department;


class AdminController extends Controller
{
    public function dashboard() {
        return view('admin/dashboard');
    }

    public function users() {
        $users = Employee::all_users();
        $departments = Department::all_departments();
        return view('admin/users', compact(['users', 'departments']));
    }

    public function create_user(Request $request) {
        $validated = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
            'position' => 'nullable',
            'department' => 'required|integer',
            'role' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'email' => 'required'
        ]);

        if($validated->fails()) {
            return redirect()->route('admin_users')->with('message', 'Invalid inputs');
        } else {
            if($request->password == $request->c_password){
                $employee = json_decode(Employee::create_user($validated->validated()));
    
                return redirect()->route('admin_users')->with('message', $employee->message);
            } else {
                return redirect()->route('admin_users')->with('message', 'User creation failed! Passwords do not match.');
            }
        }
    }

    public function update_user(Request $request, $id) {
        $validated = Validator::make($request->all(), [
            'username' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'department' => 'required|integer',
            'position' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
        
        if($validated->fails()) {
            return redirect()->route('admin_users')->with('message', 'User edit unsuccessful.');
        } else {
            if($request->password == $request->c_password) {
                $validatedData = $validated->validated();
                $validatedData['password'] = Hash::make($validatedData['password']);
                
                echo print_r($validatedData);
                $employee = json_decode(Employee::update_user($validatedData, $id));
                
                if($employee->status == 1) {
                  return redirect()->route('admin_users')->with('message', 'Update successfully!');
                } else {
                  return redirect()->route('admin_users')->with('message', 'Update failed.');
                }
            } else {
                return redirect()->route('admin_users')->with('message', 'Passwords do not match.');
            }
        }
    }

    public function delete_user($id) {
      $user = json_decode(Employee::delete_user($id));
      
      if($user->status == 1) {
        return redirect()->route('admin_users')->with('message', 'User deleted successfully!');
      } else {
        return redirect()->route('admin_users')->with('message', 'User deleted unsuccessfully!');
      }
    }
    
    public function lock_unlock_user($id) {
      Employee::lock_unlock_user($id);
      
      return redirect()->route('admin_users');
    }

    public function departments() {
        $employees = Employee::all_users();
        $departments = Department::all_departments();
        return view('admin/departments', compact('departments', 'employees'));
    }

    public function create_department(Request $request) {
        $validated = Validator::make($request->all(), [
            'department_description' => 'required',
            'department_code' => 'required',
            'manager_id' => 'nullable'
        ]);

        if($validated->fails()) {

        } else {
            $validatedData = $validated->validated();
            $department = json_decode(Department::add_department($validatedData));

            return redirect()->route('admin_departments')->with('message', $department->message);
        }
    }

    public function update_department(Request $request, $id) {
        $validated = Validator::make($request->all(), [
            'department_description' => 'required',
            'department_code' => 'required',
            'manager_id' => 'required|integer'
        ]);

        if($validated->fails()) {
            return redirect()->back()->with('message', 'Edit unsuccessful!');
        } else {
            $department = json_decode(Department::update_department($validated->validated(), $id));

            return redirect()->back()->with('message', $department->message);
        }
    }
}
