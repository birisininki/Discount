<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['name', 'color', 'message', 'is_archived'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
