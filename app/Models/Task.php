<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Team;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'contents'];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function teams()
    {
        return $this->hasOne(Team::class);
    }
}
