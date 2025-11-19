<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutExercise;

class ExerciseController extends Controller
{
    public function getExercises()
    {
        return response()->json(Exercise::all(['id', 'name']));
    }

    public function addExercise(Request $request)
    {
        $workoutName = $request->input('Workout');
        $workout = Workout::where('name', $workoutName)->firstOrFail();
        $weeks = $request->input('week', []);
        $days = $request->input('day', []);
        $exercises = $request->input('exercise', []);
        $sets = $request->input('sets', []);
        $reps = $request->input('reps', []);
        $weights = $request->input('peso', []);
        $variants = $request->input('variante', []);
        $rpes = $request->input('rpe', []);

        $inserted = 0;
        for ($i = 0; $i < count($exercises); $i++) {
            WorkoutExercise::create([
                'week' => intval($weeks[$i] ?? 1),
                'day' => intval($days[$i] ?? 1),
                'workout_id' => $workout->id,
                'exercise' => intval($exercises[$i] ?? 1),
                'sets' => intval($sets[$i] ?? 0),
                'reps' => intval($reps[$i] ?? 0),
                'weight' => floatval($weights[$i] ?? 0),
                'variant' => $variants[$i] ?? null,
                'RPE' => floatval($rpes[$i] ?? 0)
            ]);
            $inserted++;
        }

        return response()->json(['success' => true, 'inserted' => $inserted]);
    }

    public function showExercises(Request $request)
    {
        $workoutName = $request->input('workout');

        if (!$workoutName) {
            return response()->json(['error' => 'Nessun workout specificato'], 400);
        }

        $esercizi = DB::table('workouts_exercises as WE')
            ->join('workout as W', 'W.id', '=', 'WE.workout_id')
            ->join('exercise as E', 'E.id', '=', 'WE.exercise')
            ->where('W.name', $workoutName)
            ->orderBy('WE.week')
            ->orderBy('WE.day')
            ->orderBy('WE.id')
            ->select(
                'WE.week',
                'WE.day',
                'E.name',
                'WE.sets',
                'WE.reps',
                'WE.weight',
                'WE.variant',
                'WE.RPE'
            )
            ->get();

        return response()->json($esercizi);
    }
}
