<?php

namespace App\Interfaces;
use App\Models\User;

interface UserRepositoryInterface 
{
    public function get();
    public function getBanned();
    public function getByUserName($username);
    public function getById($id);
    public function getByTypeId($id);
    public function create(array $details);
    public function update(array $details, User $user);
    public function ban(User $user, $message);
    public function unban(User $user);
}