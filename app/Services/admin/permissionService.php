<?php

namespace App\Services\admin;

use App\Models\admin\Permission;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class permissionService
{
    public function indexPermission() :serviceResult
    {
        return app(serviceWrapper::class)(function (){
            return Permission::paginate(4);
        });
    }
    public function storePermission(array $inputs) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs){
            $result = Permission::create($inputs);
            return $result;
        });
    }

    public function deletePermission(Permission $permission) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($permission){
            return $permission->delete();
        });
    }
}
