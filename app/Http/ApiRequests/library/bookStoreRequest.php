<?php

namespace App\Http\ApiRequests\library;

use App\Models\library\Book;
use App\saeed\apiFormRequest;
use Illuminate\Support\Facades\Gate;

class bookStoreRequest extends apiFormRequest
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
        return Book::rules();
    }
}
