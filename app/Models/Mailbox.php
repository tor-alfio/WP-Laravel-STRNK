<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    protected $table = 'mailbox';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['user', 'notification'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification');
    }
}
