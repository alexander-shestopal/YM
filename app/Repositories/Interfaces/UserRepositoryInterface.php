<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function createUser(array $data);
    public function getUserForEmail(string $email);
    public function getUserForId(int $id);
}
