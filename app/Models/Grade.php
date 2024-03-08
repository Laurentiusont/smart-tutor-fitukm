<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class Grade extends Model
{
    use HasFactory, Uuid;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'guid';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'topic_guid', 'grade'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'status' => StatusEnum::class
    ];
    /**
     * USER OBJECT
     */
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    /**
     * TOPIC OBJECT
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
