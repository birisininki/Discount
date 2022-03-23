<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageTemplate extends Model
{
    use SoftDeletes;
    protected $fillable = ['message_code', 'message', 'request_type_id']; 

    public function request_type(){
        return $this->belongsTo(RequestType::class);
    }
}
