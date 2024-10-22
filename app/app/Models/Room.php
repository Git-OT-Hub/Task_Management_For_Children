<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants', 'room_id', 'user_id')
        ->withPivot('room_id', 'user_id', 'join_flg', 'master_flg')
        ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'room_id');
    }
}
