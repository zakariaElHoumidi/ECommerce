<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user) {
        $user->name = ucfirst($user->lastname) . ' ' . ucfirst($user->firstname);
    }
}
