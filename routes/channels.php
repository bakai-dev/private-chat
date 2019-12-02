<?php


use App\Models\Session;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Chat', function ($user) {
    return $user;
});


Broadcast::channel('Chat.{session}', function ($user, Session $session) {
    if ($user->id  === $session->user1_id || $user->id  === $session->user2_id) {
        return true;
    }
    return false;
});
