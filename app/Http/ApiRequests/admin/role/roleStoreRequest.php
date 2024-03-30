<?php

namespace App\Http\ApiRequests\admin\role;

use App\Models\admin\Role;
use App\saeed\apiFormRequest;
use Illuminate\Support\Facades\Gate;

class roleStoreRequest extends apiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Role::rules([
            'name' => 'required',
            'display_name' => 'required'
        ]);
    }
}
