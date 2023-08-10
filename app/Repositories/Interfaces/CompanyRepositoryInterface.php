<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface CompanyRepositoryInterface
{
    public function createCompany(array $data);
}
