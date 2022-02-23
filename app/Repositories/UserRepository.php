<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function get()
    {
        return User::all();
    }

    public function getBanned(){
        return User::whereNotNull('banned_at')->get();
    }

    public function getByUserName($username)
    {
        return User::where('username', $username)->first();
    }

    public function getById($id){
        return User::where('id', $id)->firstOrFail();
    }

    public function getByTypeId($id){
        return User::where('type_id', $id)->get();
    }

    public function create(array $details)
    {
        return User::create($details);
    }

    public function update(array $details, User $user)
    {
        return $user->update($details);
    }

    public function ban(User $user, $message)
    {
        return $user->update(['banned_at' => date('Y-m-d H:i'), 'ban_reason' => $message]);
    }

    public function unban(User $user)
    {
        return $user->update(['banned_at' => null, 'ban_reason' => null]);
    }

}