<?php

namespace App\Interfaces;
use App\Models\Employee;

interface EmployeeRepositoryInterface 
{
    public function all();
    public function getByUsername($username);
    public function getById($id);
    public function createEmployee(array $details);
    public function updateEmployee(array $details, Employee $employee);
    public function deleteEmployee(Employee $employee);
}