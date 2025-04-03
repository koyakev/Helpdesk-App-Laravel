<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class AuthController extends Controller
{
    public function login_form() {
        if(session('user')) {
            return redirect()->route('dashboard');
        } else {
            return view('auth/login');
        }
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        $user = json_decode(Employee::login($credentials));

        if($user->message == 'success') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login_form')->with(['message' => $user->message]);
    }

    public function signup_form() {
        $departments = Department::all_departments();
        return view('auth/signup', compact('departments'));
    }

    public function signup(Request $request) {
        $validated = Validator::make($request->all(), [
            'username' => 'required|unique:employees',
            'password' => 'required|min:8',
            'c_password' => 'required',
            'department' => 'required|integer',
            'position' => 'nullable',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required'
        ]);

        if($validated->fails()) {
            return redirect()->route('signup_form')->with('message', 'Invalid Input');
        } else {
            $validatedData = $validated->validated();
            if($validatedData['password'] == $validatedData['c_password']) {
                $user = json_decode(Employee::signup($validatedData));

                return redirect()->route('login_form')->with('message', $user->message);
            } else {
                return redirect()->route('signup_form')->with('message', 'Passwords do not match.');
            }
        }

    }

    public function dashboard() {
        if(session('user')) {
            $user = session('user')[0];

            if($user->role == 'L1') {
                return view('user/dashboard');
            } else {
                return redirect()->route('admin_dashboard');
            }
        } else {
            return redirect()->route('login_form');
        }
    }

    public function logout() {
        session()->flush();
        return redirect()->route('dashboard');
    }
}
