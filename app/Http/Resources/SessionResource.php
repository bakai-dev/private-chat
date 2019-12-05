<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'open' => false,
            'users' => [$this->user1_id, $this->user2_id],
            'unreadCount' => $this->chats->where('read_at', null)->where('type', 0)->where('user_id', '!=', auth()->id())->count(),
            'block' => !!$this->is_block,
            'blocked_by' => $this->blocked_by,
        ];
    }
}
