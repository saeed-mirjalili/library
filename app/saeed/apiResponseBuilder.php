<?php

namespace App\saeed;

class apiResponseBuilder
{
    private apiResponse $response;

    public function __construct()
    {
        $this->response = new apiResponse();
    }

    public function withMessage(string $message)
    {
        $this->response->setMessage($message);
        return $this;
    }
    public function withData(mixed $data)
    {
        $this->response->setData($data);
        return $this;
    }
    public function withAppends(array $appends)
    {
        $this->response->setAppends($appends);
        return $this;
    }
    public function withStatus(int $status)
    {
        $this->response->setStatus($status);
        return $this;
    }

    public function build() : apiResponse
    {
        return $this->response;
    }
}
