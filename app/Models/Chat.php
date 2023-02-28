<?php

namespace App\Models;

class Chat extends Model
{
    public function list($userId, $chatId)
    {
        return Chat::where('user_id', '=', $userId)
        		->where('id', '=', $chatId)
                ->first();
    }
}
