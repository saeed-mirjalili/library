<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     version="1.0",
 *     title="backend for library project"
 * )
 * @OA\tag(
 *     name="admin"
 * )
 * @OA\Schema (
 *     schema="ApiPaginate",
 *                  @OA\Property (
 *               property="current_page",
 *               type="integer",
 *               example=1,
 *              ),
 *                    @OA\Property (
 *                   property="data",
 *                   type="array",
 *                    @OA\Items(
 *                  ),
 *               ),
 *                @OA\Property (
 *                property="first_page_url",
 *                type="string",
 *                example="url",
 *               ),
 *                @OA\Property (
 *                property="from",
 *                type="integer",
 *                example=1,
 *               ),
 *                @OA\Property (
 *                property="last_page",
 *                type="integert",
 *                example=3,
 *               ),
 *                @OA\Property (
 *                property="last_page_url",
 *                type="string",
 *                example="url",
 *               ),
 *
 *
 *
 *                     @OA\Property (
 *                    property="links",
 *                    type="array",
 *                     @OA\Items(
 *                      @OA\Property (
 *                       property="url",
 *                       type="string",
 *                       nullable=false,
 *                       example="url",
 *                      ),
 *                      @OA\Property (
 *                        property="label",
 *                        type="string",
 *                        nullable=false,
 *                        example="&laquo; Previous",
 *                       ),
 *                      @OA\Property (
 *                        property="active",
 *                        type="boolean",
 *                        nullable=false,
 *                        example=true,
 *                       ),
 *                   ),
 *                ),
 *
 *
 *                     @OA\Property (
 *                 property="next_page_url",
 *                 type="string",
 *                 example="url",
 *                ),
 *                     @OA\Property (
 *                 property="path",
 *                 type="string",
 *                 example="url",
 *                ),               @OA\Property (
 *                 property="per_page",
 *                 type="integer",
 *                 example=2,
 *                ),               @OA\Property (
 *                 property="prev_page_url",
 *                 type="string",
 *                 example="url",
 *                ),               @OA\Property (
 *                 property="to",
 *                 type="integer",
 *                 example=2,
 *                ),               @OA\Property (
 *                 property="total",
 *                 type="integer",
 *                 example=2,
 *                ),
 *)
 *@OA\Schema (
 *     schema="401Error",
 *       @OA\Property (
 *        property="current_page",
 *        type="message",
 *        example="you have to login",
 *      ),
 *)
 * @OA\Schema (
 *     schema="403Error",
 *       @OA\Property (
 *        property="current_page",
 *        type="error",
 *        example="access denied",
 *      ),
 *)
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
