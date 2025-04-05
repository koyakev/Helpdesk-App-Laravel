<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Department;

class Employee extends Authenticatable
{
    protected $fillable = ['username', 'password', 'fname', 'mname', 'lname', 'email', 'emp_id', 'department', 'position', 'status', 'role', 'failed_login_attempts'];

    public static function login($credentials) {
        if (Auth::guard('employee')->attempt($credentials)) {
            $user = Employee::where('username', $credentials['username'])->first();
            
            if($user->status == 1) {
              return json_encode([
                  "message" => "success",
                  "data" => $user
              ]);
            } else {
              return json_encode([
                  "message" => "User locked."
              ]);
            }
        } else {
          $user = Employee::where('username', $credentials['username'])->first();
          
          if($user) {
            if($user->failed_login_attempts < 3) {
              $user->update([
                'failed_login_attempts' => $user->failed_login_attempts + 1
              ]);
            }
  
            if($user->failed_login_attempts == 2) {
              $user->update([
                'status' => 0
              ]);
  
              return json_encode([
                "message" => "User locked. Please contact ICT admin."
              ]);
            }
  
            return json_encode([
                "message" => "Invalid Credentials!"
            ]);
          } else {
            return json_encode([
              "message" => "User not found!"
            ]);
          }
        }
    }

    public static function signup($request) {
        $emp_code_latest = Employee::where('department', $request['department'])->orderBy('id', 'desc')->first(['emp_id']);

        if($emp_code_latest) {
          $emp_code = explode('-', $emp_code_latest->emp_id);
          $emp_code_number = (int) $emp_code[1] + 1;
          $emp_code_new_number = str_pad($emp_code_number, 4, "0", STR_PAD_LEFT);
          $emp_code_new = $emp_code[0] . '-' . $emp_code_new_number;
  
          $request['emp_id'] = $emp_code_new;
        } else {
          $department_code = Department::where('id', $request['department'])->get('department_code');
          $request['emp_id'] = $department_code[0]->department_code . '-0001';
        }

        $request['password'] = Hash::make($request['password']);
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

    public static function all_users() {
        return Employee::leftJoin('departments', 'employees.department', '=', 'departments.id')->select('employees.*', 'departments.department_description', 'departments.department_code')->get();
    }

    public static function create_user($request) {
        $emp_code_latest = Employee::orderBy('id', 'desc')->limit(1)->where('department', $request['department'])->get('emp_id');

        if(count($emp_code_latest) > 0) {
          $emp_code = explode('-', $emp_code_latest[0]->emp_id);
          $emp_code_number = (int) $emp_code[1] + 1;
          $emp_code_new_number = str_pad($emp_code_number, 4, "0", STR_PAD_LEFT);
          $emp_code_new = $emp_code[0] . '-' . $emp_code_new_number;
  
          $request['emp_id'] = $emp_code_new;
        } else {
          $department_code = Department::where('id', $request['department'])->get('department_code');
          $request['emp_id'] = $department_code[0]->department_code . '-0001';
        }

        $request['password'] = Hash::make($request['password']);
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

    public static function update_user($request, $id) {
        $user = Employee::where('id', $id);
        
        if($user != null) {
          $updated = $user->update([
            'username' => $request['username'],
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
          'status' => 1,
          'failed_login_attempts' => 0,
        ]);
      }
    }
}
