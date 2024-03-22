<?php

namespace App\Services;

class serviceResult
{
    public function __construct(public bool $ok, public mixed $data = null)
    {}
}