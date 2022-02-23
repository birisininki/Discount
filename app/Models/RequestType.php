<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $fillable = ['name', 'rules', 'code_required', 'color', 'is_archived'];

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function messages(){
        return $this->hasMany(MessageTemplate::class);
    }
}
