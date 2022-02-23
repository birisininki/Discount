<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    public function all()
    {
        return Employee::all();
    }

    public function getByUsername($username)
    {
        return Employee::where('username', $username)->firstOrFail();
    }

    public function getById($id)
    {
        return Employee::where('id', $id)->firstOrFail();
    }

    public function createEmployee(array $details)
    {
        return Employee::create($details);
    }

    public function updateEmployee(array $details, Employee $employee)
    {
        return $employee->update($details);
    }

    public function deleteEmployee(Employee $employee)
    {
        return $employee->delete();
    }

}