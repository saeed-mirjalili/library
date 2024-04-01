<?php
namespace App\Http\Models;
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
 *
 *             @OA\Property (
 *              property="current_page",
 *              type="integer",
 *              example=1,
 *             ),
 *
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
 *                 ),
 *              ),
 *
 *
 *                @OA\Property (
 *               property="first_page_url",
 *               type="string",
 *               example="url",
 *              ),
 *               @OA\Property (
 *               property="from",
 *               type="integer",
 *               example=1,
 *              ),
 *               @OA\Property (
 *               property="last_page",
 *               type="integert",
 *               example=3,
 *              ),
 *               @OA\Property (
 *               property="last_page_url",
 *               type="string",
 *               example="url",
 *              ),
 *
 *
 *
 *                    @OA\Property (
 *                   property="links",
 *                   type="array",
 *                    @OA\Items(
 *                     @OA\Property (
 *                      property="url",
 *                      type="string",
 *                      nullable=false,
 *                      example="url",
 *                     ),
 *                     @OA\Property (
 *                       property="label",
 *                       type="string",
 *                       nullable=false,
 *                       example="&laquo; Previous",
 *                      ),
 *                     @OA\Property (
 *                       property="active",
 *                       type="boolean",
 *                       nullable=false,
 *                       example=true,
 *                      ),
 *                  ),
 *               ),
 *
 *
 *                    @OA\Property (
 *                property="next_page_url",
 *                type="string",
 *                example="url",
 *               ),
 *                    @OA\Property (
 *                property="path",
 *                type="string",
 *                example="url",
 *               ),
 *     @OA\Property (
 *                property="per_page",
 *                type="integer",
 *                example=2,
 *               ),
 *     @OA\Property (
 *                property="prev_page_url",
 *                type="string",
 *                example="url",
 *               ),
 *     @OA\Property (
 *                property="to",
 *                type="integer",
 *                example=2,
 *               ),
 *     @OA\Property (
 *                property="total",
 *                type="integer",
 *                example=2,
 *               ),
 *
 *
 *
 *         )
 *     )
 * )
 * )
 */
