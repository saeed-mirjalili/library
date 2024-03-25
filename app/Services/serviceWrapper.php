<?php

namespace App\Services;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\DB;

class serviceWrapper
{
    public function __invoke(\Closure $action, \Closure $reject = null)
    {
        DB::beginTransaction();
        try {
            $actionResult = $action();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            !is_null($reject) && $reject();
            app()[ExceptionHandler::class]->report($th);
            return new serviceResult(false , $th->getMessage());
        }
    
        return new serviceResult(true , $actionResult);
    }
}
