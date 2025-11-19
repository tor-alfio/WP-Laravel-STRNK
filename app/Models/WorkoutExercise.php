<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    use HasFactory;

    protected $table = 'workouts_exercises';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'week',
        'day',
        'workout_id',
        'exercise',
        'sets',
        'reps',
        'weight',
        'variant',
        'topset',
        'RPE',
        'RIR',
        'rest'
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function exerciseData()
    {
        return $this->belongsTo(Exercise::class, 'exercise');
    }
}
