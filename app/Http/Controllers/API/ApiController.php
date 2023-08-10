<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;

class ApiController extends BaseController
{
    private $userRepository;
    private $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->createUser($input);

        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['name'] =  $user->first_name;

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $user = $this->userRepository->getUserForEmail($input['email']);

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response(['message' => 'Invalid credentials', 'status' => false], 422);
        }

        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['name'] =  $user->name;

        return response(['data' => $data, 'message' => 'Login successful!', 'status' => true]);
    }
    
    public function recoverPassword(Request $request)
    {
        if ($request->has(['email', 'password'])) {
            $user = $this->userRepository->getUserForEmail($request->email);
            if (!$user) return response()->json('User not found');
            $user->password = Hash::make($request->password);
            $user->save();
            return $user;
        }
        return response()->json('Verify email and password');
    }
    
    /**
     * @param  int $user_id
     * @return mixed
     */
    public function showUserCompanies($user_id)
    {
        return $this->userRepository->getUserForId($user_id)->companies;
    }

    public function storeCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'phone' => 'required',
            'description' => 'nullable',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $user = $this->userRepository->getUserForId($request->user_id);
        $data = $request->except(['user_id']);
        $company = $this->companyRepository->createCompany($data);
        $user->companies()->attach($company->id);

        return response(['data' => $data, 'message' => 'Create company by user successful!', 'status' => true]);
    }
}
