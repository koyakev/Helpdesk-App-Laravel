<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['department_description', 'department_code', 'manager_id'];

    public static function add_department($request) {
        $department = Department::create($request);

        if($department) {
            return json_encode([
                "message" => "Department created successfully!"
            ]);
        } else {
            return json_encode([
                "message" => "Department creation failed."
            ]);
        }
    }

    public static function all_departments() {
        return Department::leftjoin('employees', 'employees.id', '=', 'departments.manager_id')->select('departments.*', 'employees.fname', 'employees.mname', 'employees.lname')->get();
    }

    public static function update_department($request, $id) {
        $department = Department::find($id);

        $department->update([
            'department_description' => $request['department_description'],
            'department_code' => $request['department_code'],
            'manager_id' => $request['manager_id']
        ]);

        if($department) {
            return json_encode([
                'message' => 'Department updated successfully!'
            ]);
        } else {
            return json_encode([
                'message' => 'Department update failed.'
            ]);
        }

    }
}
