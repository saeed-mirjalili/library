<?php

namespace App\Http\Controllers;

use App\Http\Resources\userResource;
use App\Models\User;
use App\saeed\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class userController extends Controller
{
    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'c_password' => 'string|same:password'
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $input = $validator->validated();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $token = $user->createToken('myApp')->plainTextToken;

        return ApiResponse::withData($user)->withAppends($token)->build()->apiResponse();
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return ApiResponse::withData($validator->messages())->withStatus(500)->build()->apiResponse();
        }

        $user = User::where('email' , $request->email)->first();
        if (!$user) {
            return ApiResponse::withMessage('user not found')->withStatus(404)->build()->apiResponse();
        }
        if (!Hash::check($request->password,$user->password)) {
            return ApiResponse::withMessage('password is incorrect')->withStatus(401)->build()->apiResponse(); 
        }
        $token = $user->createToken('myApp')->plainTextToken;
        
        return ApiResponse::withData(new userResource($user->load('books')))->withAppends(['token'=>$token])->build()->apiResponse();
    }

    public function logout()
    {    
        auth()->user()->tokens()->delete();
        return ApiResponse::withMessage('logged out')->build()->apiResponse();
    }
}