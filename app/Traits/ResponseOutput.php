<?php

namespace App\Traits;

trait ResponseOutput{

    protected function Response($status=null, $message=null, $data=null, $code=200) 
    {
        $body = [];
        !is_null($status) && $body['status'] = $status;
        !is_null($message) && $body['message'] = $message;
        !is_null($data) && $body['data'] = $data;
        return response()->json($body, $code);
    }
}

