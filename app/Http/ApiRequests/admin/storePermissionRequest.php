<?php

namespace App\Http\ApiRequests\admin;

use App\Models\panel\Permission;
use App\saeed\apiFormRequest;

class storePermissionRequest extends apiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Permission::rules();
    }
}
