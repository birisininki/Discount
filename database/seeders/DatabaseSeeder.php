<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\EmployeePermission;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        Employee::create([
            'username' => 'admin',
            'name' => 'admin',
            'password' => Hash::make('admin')
        ]);

        UserType::create([
            'name' => 'standart',
            'color' => 'white',
            'message' => 'Standart kullanıcı'
        ]);
        $permissions = [
            ['permission' => 'view_employees', 'employee_id' => 1],
            ['permission' => 'create_employee', 'employee_id' => 1],
            ['permission' => 'update_employee', 'employee_id' => 1],
            ['permission' => 'delete_employee', 'employee_id' => 1],
            ['permission' => 'view_users', 'employee_id' => 1],
            ['permission' => 'update_user', 'employee_id' => 1],
            ['permission' => 'ban_user', 'employee_id' => 1],
            ['permission' => 'view_old_requests', 'employee_id' => 1],
            ['permission' => 'export_old_requests', 'employee_id' => 1],
            ['permission' => 'view_user_types', 'employee_id' => 1],
            ['permission' => 'create_user_type', 'employee_id' => 1],
            ['permission' => 'update_user_type', 'employee_id' => 1],
            ['permission' => 'archive_user_type', 'employee_id' => 1],
            ['permission' => 'view_request_types', 'employee_id' => 1],
            ['permission' => 'create_request_type', 'employee_id' => 1],
            ['permission' => 'update_request_type', 'employee_id' => 1],
            ['permission' => 'archive_request_type', 'employee_id' => 1],
            ['permission' => 'view_message_templates', 'employee_id' => 1],
            ['permission' => 'create_message_template', 'employee_id' => 1],
            ['permission' => 'update_message_template', 'employee_id' => 1],
            ['permission' => 'delete_message_template', 'employee_id' => 1],
        ];
        

        EmployeePermission::insert($permissions);
        
    }
}
