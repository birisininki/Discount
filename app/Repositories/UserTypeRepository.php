<?php

namespace App\Repositories;

use App\Interfaces\UserTypeRepositoryInterface;
use App\Models\UserType;

class UserTypeRepository implements UserTypeRepositoryInterface
{
    public function get(){
        return UserType::where('is_archived', false)->get();
    }

    public function getAll(){
        return UserType::all();
    }

    public function getById($id){
        return UserType::where('id', $id)->firstOrFail();
    }

    public function create(array $details)
    {
        return UserType::create($details);
    }

    public function update(array $details, UserType $user_type)
    {
        return $user_type->update($details);
    }

    public function archive(UserType $user_type)
    {
        return $user_type->update(['is_archived' => true]);
    }

    public function unarchive(UserType $user_type)
    {
        return $user_type->update(['is_archived' => false]);
    }

}