<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Session $session, Request $request)
    {
        $message = $session->messages()->create([
            'content' => $request->message
        ]);

        $message->chats()->create([
            'session_id' => $session->id,
            'type' => 0,
            'user_id' => auth()->id(),
        ]);

        $message->chats()->create([
            'session_id' => $session->id,
            'type' => 0,
            'user_id' => $request->to_user,
        ]);

        return $message;
    }
}
