<?php

namespace App\Http\Controllers;

use App\Http\ApiRequests\user\loginUserRequest;
use App\Http\ApiRequests\user\registerUserRequest;
use App\Http\Resources\userResource;
use App\Models\User;
use App\saeed\Facades\ApiResponse;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function register(registerUserRequest $request) 
    {

        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        return ApiResponse::withData(new userResource($user))->withAppends(['token'=>$token])->build()->apiResponse();
    }

    public function login(loginUserRequest $request) 
    {

        $user = User::where('email' , $request->email)->first();
        if (!$user) {
            return ApiResponse::withMessage('user not found')->withStatus(401)->build()->apiResponse();
        }
        if (!Hash::check($request->password,$user->password)) {
            return ApiResponse::withMessage('password is incorrect')->withStatus(401)->build()->apiResponse(); 
        }
        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;
        
        return ApiResponse::withData(new userResource($user->load('books')))->withAppends(['token'=>$token])->build()->apiResponse();
    }

    public function logout()
    {    
        auth()->user()->currentAccessToken()->delete();
        return ApiResponse::withMessage('logged out')->build()->apiResponse();
    }
}