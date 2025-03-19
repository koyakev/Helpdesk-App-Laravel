<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Employee extends Authenticatable
{
    protected $fillable = ['username', 'password', 'fname', 'mname', 'lname', 'email', 'emp_id', 'department', 'position', 'status', 'active', 'role'];

    public static function login($credentials) {
        if (Auth::guard('employee')->attempt($credentials)) {
            $user = Employee::where('username', $credentials['username'])->get();
            session()->put('user', $user);
            return json_encode([
                "message" => "success"
            ]);
        }

        return json_encode([
            "message" => "Invalid Credentials"
        ]);
    }

    public static function signup($request) {
        $request['password'] = Hash::make($request['password']);
        $user = Employee::create($request);
        
        if($user) {
            return json_encode([
                "message" => "User created successfully!"
            ]);
        }

        return json_encode([
            "message" => "User creation failed."
        ]);
    }

    public static function all_users() {
        return Employee::leftJoin('departments', 'employees.department', '=', 'departments.id')->select('employees.*', 'departments.*')->get();
    }

    public static function create_user($request) {
        $user = Employee::create($request);

        if($user) {
            return json_encode([
                "message" => "User created successfully!",
            ]);
        } else {
            return json_encode([
                "message" => "User creation failed."
            ]);
        }
    }

    public static function update_user($request) {
        $user = Employee::where('emp_id', $request['emp_id']);
        
        if($user != null) {
          $updated = $user->update([
            'fname' => $request['fname'],
            'mname' => $request['mname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'position' => $request['position'],
            'department' => $request['department'],
            'role' => $request['role'],
            'password' => $request['password'],
          ]);
        } else {          
          $updated = $user->update($request);
        }

        if($updated) {
            return json_encode(['status' => 1]);
        } else {
            return json_encode(['status' => 0]);
        }
    }
    
    public static function delete_user($id) {
      $user = Employee::find($id);
      $user->delete();
      
      if($user) {
        return json_encode(['status' => 1]);
      } else {
        return json_encode(['status' => 0]);
      }
    }
    
    public static function lock_unlock_user($id) {
      $user = Employee::where('id', $id)->first();
      
      if($user->status == 1) {
        $user->update([
          'status' => 0
        ]);
      } else {
        $user->update([
          'status' => 1
        ]);
      }
    }
}
