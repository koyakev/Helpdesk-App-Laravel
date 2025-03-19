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
        return Department::all();
    }
}
