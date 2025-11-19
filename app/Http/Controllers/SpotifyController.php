<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return "Codice assente!";
        }

        return view('callback', compact('code'));
    }
}
