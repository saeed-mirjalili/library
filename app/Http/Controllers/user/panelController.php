<?php

namespace App\Http\Controllers\user;

use App\Http\ApiRequests\panelAddBooksRequest;
use App\Http\ApiRequests\panelRemoveBookRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\library\bookResource;
use App\Http\Resources\user\userResource;
use App\Models\library\Book;
use App\saeed\Facades\ApiResponse;
use App\Services\panelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class panelController extends Controller
{
    public function __construct(private panelService $panelService){}
    public function addBook(Book $book) {

        $result = $this->panelService->addBook($book);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('add book successful')->build()->apiResponse();
    }

    public function addBooks(panelAddBooksRequest $request) {

        $result = $this->panelService->addBooks($request);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withData($result->data)->build()->apiResponse();
    }

    public function showBook() {
        $result = $this->panelService->showBook();
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage('show books successful')->withData(new userResource($result->data->load('books')))->build()->apiResponse();
    }

    public function removebooks(panelRemoveBookRequest $request) {

        $result = $this->panelService->removebooks($request);
        if (!$result->ok) {
            return ApiResponse::withMessage('error')->withData($result->data)->withStatus(500)->build()->apiResponse();
        }
        return ApiResponse::withMessage($result->data)->build()->apiResponse();
    }
}
