<?php

namespace App\Http\ApiRequests\admin\role;

use App\Models\admin\Role;
use App\saeed\apiFormRequest;
use Illuminate\Support\Facades\Gate;

class roleUpdateRequest extends apiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('change');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Role::rules();
    }
}
