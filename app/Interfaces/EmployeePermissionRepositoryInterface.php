<?php

namespace App\Interfaces;
use App\Models\Employee;

interface EmployeePermissionRepositoryInterface 
{
    public function set(array $permissions, Employee $employee);
    public function delete(Employee $employee);
}