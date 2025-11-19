<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruolo extends Model
{
    protected $table = 'ruolo';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['utente', 'ruolo'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'utente', 'id');
    }

}
