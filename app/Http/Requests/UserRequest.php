<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserRequest extends Request
{
    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required'
    //     ];
    // }
}