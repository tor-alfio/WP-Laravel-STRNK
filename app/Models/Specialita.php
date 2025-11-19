<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialita extends Model
{
    protected $table = 'specialita';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['utente', 'specialita'];

    public function user()
    {
        return $this->belongsTo(User::class, 'utente', 'id');
    }

}
