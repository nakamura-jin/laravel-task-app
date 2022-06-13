<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Task;
use App\Models\Team;
use App\Models\Role;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'worker_number',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function roles()
    {
        return $this->hasOne(Role::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
