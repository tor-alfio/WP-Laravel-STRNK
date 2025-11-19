<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ruolo;
use App\Models\Specialita;
use App\Models\Workout;
use App\Models\SavedWorkout;
use App\Models\Notification;
use App\Models\Mailbox;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers()
    {
    $user = Auth::user();

    $utenti = User::with(['ruoli', 'specialita'])
        ->where('id', '!=', $user->id)
        ->get()
        ->map(function ($u) {
            return [
                'id' => $u->id,
                'nome_completo' => trim($u->first_Name . ' ' . $u->last_Name),
                'pfp' => $u->pfp,
                'ruoli' => $u->ruoli->pluck('ruolo')->join(', '),
                'specialita' => $u->specialita->pluck('specialita')->join(', ')
            ];
        });

    return response()->json(['success' => true,'utente' => $utenti,'user'=> $user->id]);
    }

    public function usersView()
    {
        $user = Auth::user();
        return view('users', compact('user'));
    }

    public function sendWorkout(Request $request)
{
    $currentUser = Auth::user();
    $userId = $request->input('id');
    $workoutName = $request->input('wid');

    try {
        $workout = Workout::where('name', $workoutName)->firstOrFail();
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => 'Workout non trovato: ' . $e->getMessage()]);
    }

    try {
        SavedWorkout::create([
            'user' => $userId,
            'workout' => $workout->id
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => 'Errore saving workout: ' . $e->getMessage()]);
    }

    try {
        $notification = Notification::create([
            'type' => 'allenamentoCoach',
            'sentBy' => $currentUser->id,
            'text' => $workoutName,
            'momentInserted' => now(),
            'seen' => 0
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => 'Errore creando notifica: ' . $e->getMessage()]);
    }

    try {
        Mailbox::create([
            'user' => $userId,
            'notification' => $notification->id
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => 'Errore inserimento mailbox: ' . $e->getMessage()]);
    }

    // Tutto ok
    return response()->json(['success' => true]);
}

}
