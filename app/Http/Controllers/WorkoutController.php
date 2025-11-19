<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Workout;
use App\Models\User;
use App\Models\SavedWorkout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function allenamenti()
    {
        $user = Auth::user();

        $allenamenti = Workout::join('saved_workouts', 'workout.id', '=', 'saved_workouts.workout')
            ->join('user as U', 'saved_workouts.user', '=', 'U.id')
            ->join('user as C', 'workout.creator', '=', 'C.id')
            ->where('U.id', $user->id)
            ->orderBy('workout.start_date', 'DESC')
            ->select('workout.name', 'workout.weeks', 'workout.days',
                     \DB::raw("CONCAT(C.first_name, ' ', C.last_name) as coach"),
                     'workout.start_date', 'workout.finish_date')
            ->get();

        return view('allenamenti', compact('user', 'allenamenti'));
    }
    public function allenamentiHome(Request $request)
    {   
        $user = Auth::user();

        $allenamenti = Workout::join('saved_workouts', 'workout.id', '=', 'saved_workouts.workout')
            ->join('user as U', 'saved_workouts.user', '=', 'U.id')
            ->join('user as C', 'workout.creator', '=', 'C.id')
            ->where('U.id', $user->id)
            ->orderBy('workout.start_date', 'DESC')
            ->select('workout.name', 'workout.weeks', 'workout.days',
                     \DB::raw("CONCAT(C.first_name, ' ', C.last_name) as coach"),
                     'workout.start_date', 'workout.finish_date')
            ->get();
        $workoutName = $request->query('WorkoutName');
        return view('allenamenti', compact('workoutName', 'user', 'allenamenti'));
    }

    public function programmazione()
    {
        $user = Auth::user();

        $allenamenti = Workout::where('creator', $user->id)
            ->orderBy('start_date', 'DESC')
            ->select('name', 'weeks', 'days', 'start_date', 'finish_date')
            ->get();

        return view('programmazione', compact('user', 'allenamenti'));
    }

    public function getTraining(Request $request)
    {
    $date = $request->input('data') ?? $request->json('data');
    
    $user = Auth::user();

    $workout = Workout::whereHas('savedWorkouts', function($q) use ($user) {
        $q->where('user', $user->id);
    })
    ->where('start_date', $date)
    ->first();

    return response()->json([
        'name' => $workout?->name ?? null
    ]);
    }


    public function addWorkout(Request $request)
    {
        $user = Auth::user();

        $nome = $request->input('nome') ?? "Allenamento del " . $request->input('date');
        $days = $request->filled('days') ? $request->input('days') : 1;
        $type = $request->input('type', null);

        if ($request->filled('start_date')) {
            $start_date = $request->input('start_date');
            $finish_date = $request->input('finish_date');
            $weeks = $request->input('weeks');
        } else {
            $start_date = $request->input('date');
            $finish_date = null;
            $weeks = 0;
        }

        $workout = Workout::create([
            'name' => $nome,
            'weeks' => $weeks,
            'days' => $days,
            'creator' => $user->id,
            'start_date' => $start_date,
            'finish_date' => $finish_date,
            'type' => $type,
        ]);

        SavedWorkout::create([
            'user' => $user->id,
            'workout' => $workout->id
        ]);

        return redirect()->route('allenamenti');
    }

    public function deleteWorkout(Request $request)
    {
        $user = Auth::user();
        $nome = $request->input('nome');

        $workout = Workout::where('name', $nome)->where('creator', $user->id)->firstOrFail();
        $workout->delete();

        return response()->json(['success' => true]);
    }
}

