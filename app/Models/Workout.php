<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $table = 'workout';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'weeks',
        'days',
        'creator',
        'type',
        'start_date',
        'finish_date'
    ];

    public function creatorUser()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_id');
    }

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'saved_workouts', 'workout', 'user');
    }

    public function savedWorkouts()
    {
    return $this->hasMany(SavedWorkout::class, 'workout', 'id');
    }

}
