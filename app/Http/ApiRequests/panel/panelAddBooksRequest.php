<?php

namespace App\Http\ApiRequests\panel;

use App\saeed\apiFormRequest;

class panelAddBooksRequest extends apiFormRequest
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
        return [
            'books' => 'required|array|min:1',
            'books.*' => 'numeric'
        ];
    }
}
