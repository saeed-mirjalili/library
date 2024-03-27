<?php

namespace App\Services\user;

use App\Models\user\User;
use App\Services\serviceResult;
use App\Services\serviceWrapper;
use Illuminate\Support\Facades\Hash;

class userService
{
    public function registerUser(array $inputs, string $agent): serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs,$agent) {
            $inputs['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);
            $token = $user->createToken($agent)->plainTextToken;
            $user['token']=$token;

            return $user;
        });
    }
    public function loginUser(mixed $inputs) : serviceResult {
        return app(serviceWrapper::class)(function () use($inputs) {
            $user = User::where('email' , $inputs->email)->first();
            if (!$user) {
                return [
                    'status' => 404,
                    'message'=>'user not found!'
                ];
            }
            if (!Hash::check($inputs->password,$user->password)) {
                return [
                    'status' => 401,
                    'message'=>'password is incorrect!'
                ];
            }
            $token = $user->createToken('myApp')->plainTextToken;
            $user['token']=$token;

            return $user;
        });
    }
}
