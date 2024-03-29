<?php

namespace App\Services\admin;

use App\Models\panel\Role;
use App\Services\serviceResult;
use App\Services\serviceWrapper;

class roleService
{
    public function indexRole() :serviceResult
    {
        return app(serviceWrapper::class)(function (){
            return Role::paginate(4);
        });
    }
    public function storeRole(array $inputs) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs){
            $result = Role::create($inputs);
            return $result;
        });
    }
    public function showRole(mixed $inputs) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs){
            return $inputs;
        });
    }
    public function updateRole(mixed $inputs, Role $role) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($inputs,$role){
            if($inputs->has('name')){
                $role->update($inputs->except('user','permission'));
            }
            if($inputs->has('user')){
                $role->users()->sync($inputs->user);
            }
            if($inputs->has('permission')){
                $role->permissions()->sync($inputs->permission);
            }
            return $role;
        });
    }
    public function deleteRole(Role $role) :serviceResult
    {
        return app(serviceWrapper::class)(function () use($role){
            return $role->delete();
        });
    }
}
