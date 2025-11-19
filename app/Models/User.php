<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'first_Name',
        'last_Name',
        'sex',
        'email',
        'password',
        'birthday',
        'pfp'
    ];

    protected $hidden = [
        'password',
    ];

    public function workouts()
    {
        return $this->hasMany(Workout::class, 'creator');
    }

    public function ruoli()
    {
        return $this->hasMany(Ruolo::class, 'utente', 'id');
    }

    public function specialita()
    {
        return $this->hasMany(Specialita::class, 'utente', 'id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'user1');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'user2');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'sentBy');
    }

    public function mailbox()
    {
        return $this->hasMany(Mailbox::class, 'user');
    }

    public function savedWorkouts()
    {
        return $this->belongsToMany(Workout::class, 'saved_workouts', 'user', 'workout');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
