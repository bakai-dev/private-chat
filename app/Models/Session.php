<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * @package App\Models
 *
 * @property boolean block
 */
class Session extends Model
{

    protected $guarded = [];

    public function chats()
    {
        return $this->hasManyThrough(Chat::class, Message::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function deleteChats()
    {
        $this->chats()->where('user_id', auth()->id())->delete();
    }

    public function deleteMessages()
    {
        $this->messages()->delete();
    }


    public function block()
    {
        $this->is_block = true;
        $this->blocked_by = auth()->id();
        $this->save();
    }

    public function unblock()
    {
        $this->is_block = false;
        $this->blocked_by = null;
        $this->save();
    }
}
