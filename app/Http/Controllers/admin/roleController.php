<?php

namespace App\Http\Controllers\admin;

use App\Http\ApiRequests\admin\storeRoleRequest;
use App\Http\ApiRequests\admin\updateRoleRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\roleResource;
use App\Models\panel\Role;
use App\saeed\Facades\ApiResponse;
use App\Services\admin\roleService;
use Illuminate\Http\Request;

class roleController extends Controller
{
    public function __construct(private roleService $roleService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->roleService->indexRole();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(roleResource::collection($result->data)->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRoleRequest $request)
    {
        $result = $this->roleService->storeRole($request->validated());
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new roleResource($result->data))->build()->apiResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $result = $this->roleService->showRole($role);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new roleResource(($result->data)->load('users')->load('permissions')))->build()->apiResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRoleRequest $request, Role $role)
    {

        $result = $this->roleService->updateRole($request, $role);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new roleResource($result->data))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {

        $result = $this->roleService->deleteRole($role);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
