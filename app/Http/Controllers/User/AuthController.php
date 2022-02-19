<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request, UserService $userService)
    {
        $data = $userService->register($request);

        //Error handling
        if(!$data['status'])
            return $this->error('user creation error',500, [
                'code' => $data['code']
            ]);

        //Success response with user's data
        return $this->success([
            $data['data'],
        ]);
    }

    public function login(UserLoginRequest $request, UserService $userService)
    {
        $data = $userService->login($request);

        if(!$data['status'])
            return $this->error('Credentials not match',401);

        if($data['status'])
            return $this->success([
                'user' => $data
            ],'welcome');
    }



    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success('You are logged out');
    }
}
