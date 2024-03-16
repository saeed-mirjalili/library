<?php

namespace App\Http\Controllers;

use App\Http\Resources\userResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class userController extends mainController
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
            return $this->Response('Error',$validator->messages(),null,500);
        }

        $input = $validator->validated();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $token = $user->createToken('myApp')->plainTextToken;

        return $this->Response('register', 'success', [
            'user' => $user,
            'token'=>$token
        ], 200);
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->Response('Error',$validator->messages(),null,500);
        }

        $user = User::where('email' , $request->email)->first();
        if (!$user) {
            return $this->Response('Error', 'user not found', null, 404);
        }
        if (!Hash::check($request->password,$user->password)) {
            return $this->Response('Error', 'password is incorrect', null, 401);
        }
        $token = $user->createToken('myApp')->plainTextToken;
        return $this->Response('login', 'success', [
            'user' => new userResource($user->load('books')),
            'token'=>$token
        ], 200);
    }

    public function logout()
    {    
        auth()->user()->tokens()->delete();
        return $this->Response('logout', 'logged out',null,200);
    }
}