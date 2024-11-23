<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meeting_id',
        'topic',
        'start_time',
        'join_url',
        'role',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
