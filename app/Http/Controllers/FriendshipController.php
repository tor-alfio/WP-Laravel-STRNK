<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\Mailbox;

class FriendshipController extends Controller
{
    public function checkFriendship(Request $request)
    {
        $id1 = $request->input('id1');
        $id2 = $request->input('id2');

        $friendship = Follow::where(function($q) use ($id1, $id2){
            $q->where('user1', $id1)->where('user2', $id2);
        })->orWhere(function($q) use ($id1, $id2){
            $q->where('user1', $id2)->where('user2', $id1);
        })->first();

        return response()->json(['stato' => $friendship?->stato ?? 'non amici']);
    }

   public function sendFriendship(Request $request)
    {
    $id1 = $request->input('id2');
    $id2 = $request->input('id1');

    $exists = Follow::where('user1', $id1)
                    ->where('user2', $id2)
                    ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Richiesta di amicizia già inviata'
        ]);
    }

    Follow::create([
        'user1' => $id1,
        'user2' => $id2,
        'stato' => 'in sospeso'
    ]);

    $notification = Notification::create([
            'type' => 'amicizia',
            'sentBy' => $id1,
            'text' => 'Ti ha inviato una richiesta di amicizia',
            'momentInserted' => now(),
            'seen' => 0
        ]);

    Mailbox::create([
            'user' => $id2,
            'notification' => $notification->id
        ]);

    return response()->json(['success' => true]);
    }


    public function acceptFriendship(Request $request)
    {
    $id1 = Auth::id();
    $id2 = $request->input('id2');
    $notificationId = $request->input('notification');

    Follow::where(function($q) use ($id1, $id2){
        $q->where('user1', $id1)->where('user2', $id2);
    })->orWhere(function($q) use ($id1, $id2){
        $q->where('user1', $id2)->where('user2', $id1);
    })->update(['stato' => 'amici']);

    Notification::where('id', $notificationId)->update(['seen' => 1]);

    return response()->json(['success' => true]);
    }



}
