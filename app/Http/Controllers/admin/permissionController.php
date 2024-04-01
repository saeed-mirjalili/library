<?php

namespace App\Http\Controllers\admin;

use App\Http\ApiRequests\admin\permission\permissionDeleteRequest;
use App\Http\ApiRequests\admin\permission\permissionIndexRequest;
use App\Http\ApiRequests\admin\permission\permissionStoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\permissionResource;
use App\Models\admin\Permission;
use App\saeed\Facades\ApiResponse;
use App\Services\admin\permissionService;

class permissionController extends Controller
{
    public function __construct(private permissionService $permissionService){}
    /**
     * @OA\Get(
     *     path="/api/permissions",
     *     tags={"admin"},
     *     security={{"sanctum":{}}},
     *     description="",
     *     summary="admin can make permission and role for user",
     *     @OA\Response(
     *     response=200,
     *     description="Display a listing of the permission.",
     *     @OA\JsonContent(
     *         @OA\Property (
     *             property="data",
     *             type="object",
     *               @OA\Property (
     *                  property="data",
     *                  type="array",
     *                   @OA\Items(
     *                    @OA\Property (
     *                     property="name",
     *                     type="string",
     *                     nullable=false,
     *                     example="admin",
     *                    ),
     *                    @OA\Property (
     *                      property="display_name",
     *                      type="string",
     *                      nullable=false,
     *                      example="Admin",
     *                     ),
     *                          @OA\Property (
     *                     property="roles",
     *                     type="array",
     *                      @OA\Items(
     *                       @OA\Property (
     *                        property="name",
     *                        type="string",
     *                        nullable=false,
     *                        example="name",
     *                       ),
     *                       @OA\Property (
     *                         property="display_name",
     *                         type="string",
     *                         nullable=false,
     *                         example="Name",
     *                        ),
     *                    ),
     *                 ),
     *                 ),
     *              ),
     *         )
     *     )
     * )
     * )
     */
    public function index(permissionIndexRequest $authorize)
    {
        $result = $this->permissionService->indexPermission();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData(permissionResource::collection($result->data->load('roles'))->resource)->build()->apiResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(permissionStoreRequest $request)
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
    public function destroy(Permission $permission, permissionDeleteRequest $authorize)
    {

        $result = $this->permissionService->deletePermission($permission);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('The deletion was successful')->build()->apiResponse();
    }
}
