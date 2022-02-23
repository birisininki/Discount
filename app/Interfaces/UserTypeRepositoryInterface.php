<?php

namespace App\Interfaces;
use App\Models\UserType;

interface UserTypeRepositoryInterface 
{
    public function get();
    public function getAll();
    public function getById($id);
    public function create(array $details);
    public function update(array $details, UserType $user_type);
    public function archive(UserType $user_type);
    public function unarchive(UserType $user_type);
}