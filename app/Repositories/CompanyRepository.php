<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function createCompany(array $data)
    {
        return Company::create($data);
    }
}
