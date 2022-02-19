<?php

namespace App\Services;


use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function register(UserRegisterRequest $request)
    {

        try {

            $request->merge([
                'password' => bcrypt($request->get('password'))
            ]);
            $user = User::create($request->validated());

        } catch (\Exception $e) {
            $errorCode = mt_rand(1267,99999);
            Log::error('Error Number : ' . $errorCode . ' | User creation error : ' . $e->getMessage());
            return [
                'status' => false,
                'code' => $errorCode
            ];
        }
        //TODO email

        return [
            'status' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken
            ]
        ];
    }

    public function login(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->all()))
            return [
                'status' => false
            ];

        return [
            'status' => true,
            'data' => [
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ]
        ];
    }
}
