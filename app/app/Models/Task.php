<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'task_sender',
        'task_recipient',
        "title",
        "deadline",
        "point",
        "body",
        "image",
        "complete_flg",
        "approval_flg",
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function taskSender()
    {
        return $this->belongsTo(User::class, 'task_sender');
    }

    public function taskRecipient()
    {
        return $this->belongsTo(User::class, 'task_recipient');
    }
}
