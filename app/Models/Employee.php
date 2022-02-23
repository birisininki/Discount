<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function logs(){
        return $this->hasMany(Log::class, 'user_id')->orderBy('created_at', 'DESC');
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function permissions(){
        return $this->hasMany(EmployeePermission::class);
    }

    public function getOldRequestsAttribute(){
        return $this->requests()->where('status', Request::STATUS_APPROVED)->get()->merge($this->requests()->where('status', Request::STATUS_DECLINED)->get())->sortByDesc('created_at');
    }

    public function hasPermissionOn($permission){
        return $this->permissions()->where('permission', $permission)->count();
    }

}
