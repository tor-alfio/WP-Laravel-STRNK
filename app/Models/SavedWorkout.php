<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedWorkout extends Model
{
    protected $table = 'saved_workouts';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['user', 'workout'];

    public function savedBy()
    {
        return $this->hasMany(SavedWorkout::class, 'workout');
    }
    
    public function workout()
    {
    return $this->belongsTo(Workout::class, 'workout_id', 'id');
    }

}
