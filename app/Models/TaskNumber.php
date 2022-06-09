<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class TaskNumber extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'task_count'];

    public function teams() {
        return $this->belongsToMany(Taem::class);
    }
}
