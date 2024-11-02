<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
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

    public function earnedPoint()
    {
        return $this->hasOne(EarnedPoint::class, 'room_id');
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class, 'room_id');
    }
}
