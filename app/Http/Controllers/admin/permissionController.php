<?php

namespace App\Http\Controllers\admin;

use App\Http\ApiRequests\admin\storePermissionRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\permissionResource;
use App\Models\panel\Permission;
use App\saeed\Facades\ApiResponse;
use App\Services\admin\permissionService;
use Illuminate\Http\Request;

class permissionController extends Controller
{
    public function __construct(private permissionService $permissionService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->permissionService->indexPermission();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(permissionResource::collection($result->data)->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storePermissionRequest $request)
    {
        $result = $this->permissionService->storePermission($request->validated());
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(new permissionResource($result->data))->build()->apiResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {

        $result = $this->permissionService->deletePermission($permission);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
