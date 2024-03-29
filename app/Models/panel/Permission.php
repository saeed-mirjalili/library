<?php

namespace App\Models\panel;

use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes,HasRules;

    protected $guarded=[];

    protected static function boot() {
        parent::boot();
        static::created(function ($permission){
            Role::whereName('admin')->first()->permissions()->attach([$permission->id]);
        });
    }

    protected static $rules = [
        'name' => 'required|string',
        'display_name' => 'required|string'
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}















