<?php

namespace App\Repositories;

use App\Interfaces\EmployeePermissionRepositoryInterface;
use App\Models\EmployeePermission;
use App\Models\Employee;

class EmployeePermissionRepository implements EmployeePermissionRepositoryInterface
{

    public function set(array $permissions, Employee $employee)
    {
        $this->delete($employee);
        foreach($permissions as $permission){
            $permission = array_merge($permission, ['employee_id' => $employee->id]);
            if(!EmployeePermission::create($permission)){
                return false;
            }
        }
        return true;
    }

    public function delete(Employee $employee){
        $employee->permissions()->delete();
    }

}