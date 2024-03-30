<?php

namespace App\Http\Controllers\admin;

use App\Http\ApiRequests\admin\role\roleDeleteRequest;
use App\Http\ApiRequests\admin\role\roleIndexRequest;
use App\Http\ApiRequests\admin\role\roleShowRequest;
use App\Http\ApiRequests\admin\role\roleStoreRequest;
use App\Http\ApiRequests\admin\role\roleUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\roleResource;
use App\Models\admin\Role;
use App\saeed\Facades\ApiResponse;
use App\Services\admin\roleService;

class roleController extends Controller
{
    public function __construct(private roleService $roleService){}
    /**
     * Display a listing of the resource.
     */
    public function index(roleIndexRequest $authorize)
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
    public function store(roleStoreRequest $request)
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
    public function show(Role $role, roleShowRequest $authorize)
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
    public function update(Role $role, roleUpdateRequest $request)
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
    public function destroy(Role $role, roleDeleteRequest $authorize)
    {

        $result = $this->roleService->deleteRole($role);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
