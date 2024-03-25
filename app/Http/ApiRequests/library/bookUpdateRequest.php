<?php

namespace App\Http\ApiRequests\library;

use App\Models\Book;
use App\saeed\apiFormRequest;

class bookUpdateRequest extends apiFormRequest
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

        return Book::rules([
            'name' => 'string',
            'summary' => 'string',
            'edition' => 'date_format:Y',
            'author_id' => 'numeric',
            'category_id' => 'numeric',
            'book_url' => 'mimes:pdf'
        ]);
    }
}
