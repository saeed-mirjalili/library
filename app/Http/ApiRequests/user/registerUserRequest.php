<?php

namespace App\Http\ApiRequests\user;

use App\Models\user\User;
use App\saeed\apiFormRequest;

class registerUserRequest extends apiFormRequest
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
        return User::rules([
            'name' => 'required|string',
            'c_password' => 'required|string|same:password'
        ]);
    }
}
