<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'ip_address',
        'banned_at',
        'ban_reason',
        'type_id',
        'user_id'
    ];

    protected $casts = ['banned_at' => 'datetime'];

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function logs(){
        return $this->hasMany(Log::class)->orderBy('created_at', 'DESC');
    }

    public function type(){
        return $this->belongsTo(UserType::class, 'type_id');
    }

    public function getHasActiveRequestAttribute(){
        //return $this->requests()->where('status', Request::STATUS_NEW)->count() || $this->requests()->where('status', Request::STATUS_ON_PROCESS)->count();
        return $this->requests()->whereIn('status', [Request::STATUS_NEW, Request::STATUS_ON_PROCESS])->count();
    }

    public function getActiveRequestsAttribute(){
        //return $this->requests()->where('status', Request::STATUS_NEW)->get()->merge($this->requests()->where('status', Request::STATUS_ON_PROCESS)->get())->sortByDesc('created_at');
        return $this->requests()->whereIn('status', [Request::STATUS_NEW, Request::STATUS_ON_PROCESS])->orderBy('created_at', 'DESC')->get();
    }

    public function getOldRequestsAttribute(){
        //return $this->requests()->where('status', Request::STATUS_APPROVED)->get()->merge($this->requests()->where('status', Request::STATUS_DECLINED)->get())->sortByDesc('created_at');
        return $this->requests()->whereIn('status', [Request::STATUS_APPROVED, Request::STATUS_DECLINED])->orderBy('created_at', 'DESC')->get();
    }

}
