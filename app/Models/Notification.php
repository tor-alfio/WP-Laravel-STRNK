<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['type', 'sentBy', 'text', 'momentInserted', 'seen'];
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sentBy');
    }

    public function mailboxes()
    {
        return $this->hasMany(Mailbox::class, 'notification');
    }
}
