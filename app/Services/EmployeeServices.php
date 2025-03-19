namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function editUserWithEmployee($user, $employee)
    {
        return DB::transaction(function () use ([$userData, $employeeData]) {
            $user = User::where('user_id');
            
            if($user) {
              $user->([]);
            }
        })
    }
}