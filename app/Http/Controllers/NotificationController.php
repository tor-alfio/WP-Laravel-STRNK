<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        
        $notifications = Notification::with('sender')
            ->whereHas('mailboxes', fn($q) => $q->where('user', $user->id))
            ->orderBy('momentInserted', 'desc')
            ->get();

        $result = $notifications->map(function($n) {
            return [
                'id' => $n->id,
                'type' => $n->type,
                'text' => $n->text,
                'seen' => $n->seen,
                'sentBy' => $n->sentBy,
                'pfp' => $n->sender?->pfp,
                'nome_completo' => $n->sender ? trim($n->sender->first_Name . ' ' . $n->sender->last_Name) : null
            ];
        });

        return response()->json($result);
    }
}
