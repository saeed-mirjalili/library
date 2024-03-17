<?php

namespace App\saeed;

class apiResponse
{
    private int $status = 200;
    private ?string $message = null;
    private mixed $data = null;
    private array $appends = [];

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
    public function setAppends(array $appends): void
    {
        $this->appends = $appends;
    }

    public function apiResponse()
    {
        $body = [];
        !is_null($this->message) && $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        !is_null($this->appends) && $body = $body + $this->appends;
        return response()->json($body, $this->status);
    }
}
