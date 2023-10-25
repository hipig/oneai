<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function own(User $user, Chat $chat): bool
    {
        return $chat->user_id === $user->id;
    }
}
