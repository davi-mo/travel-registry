<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param string $userId
     * @return User|null
     */
    public function getById(string $userId) : ?User
    {
        return User::find($userId);
    }

    public function updateUser(User $user, string $name)
    {
        $user->name = $name;
        $user->updated_at = now();
        $user->save();
    }
}
