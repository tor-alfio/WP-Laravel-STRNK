<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follow';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = ['user1', 'user2', 'stato'];

    public function follower()
    {
        return $this->belongsTo(User::class, 'user1');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'user2');
    }
}
