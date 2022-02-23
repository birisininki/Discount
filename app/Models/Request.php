<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    const STATUS_NEW = 0;
    const STATUS_ON_PROCESS = 1;
    const STATUS_APPROVED = 2;
    const STATUS_DECLINED = 3;

    protected $fillable = [
                            'user_id',
                            'employee_id',
                            'type_id',
                            'amount',
                            'handle_datetime',
                            'process_datetime',
                            'message',
                            'status',
                            'promotion_code'
                        ];
    
    protected $casts = ['handle_datetime' => 'datetime', 'process_datetime' => 'datetime'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function type(){
        return $this->belongsTo(RequestType::class, 'type_id');
    }

    public function getQueueAttribute(){
       return Request::where('created_at', '<', $this->created_at)->whereIn('status', [0,1])->count() +1;
    }
}
