<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function getUserForEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function getUserForId(int $id)
    {
        return User::find($id);
    }
}
