<?php

namespace App\Http\Controllers\user;

use App\Http\ApiRequests\user\loginUserRequest;
use App\Http\ApiRequests\user\registerUserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\user\userResource;
use App\Models\user\User;
use App\saeed\Facades\ApiResponse;
use App\Services\user\userService;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function __construct(private userService $userService){}
    public function register(registerUserRequest $request)
    {

        $result = $this->userService->registerUser($request->validated(), $request->header('User-Agent'));

        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new userResource($result->data))->build()->apiResponse();
    }

    public function login(loginUserRequest $request)
    {

        $result = $this->userService->loginUser($request);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        if (isset($result->data['status'])) {
            return ApiResponse::withMessage($result->data['message'])->withStatus($result->data['status'])->build()->apiResponse();
        }
        return ApiResponse::withData(new userResource($result->data->load('books')))->build()->apiResponse();
    }

    public function logout()
    {
        $result = $this->userService->logoutUser();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }

        return ApiResponse::withMessage('logged out')->build()->apiResponse();
    }
}
