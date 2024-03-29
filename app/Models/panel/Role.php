<?php

namespace App\Models\panel;

use App\Models\user\User;
use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes,HasRules;

    protected $guarded=[];

    protected static $rules = [
        'name' => 'string',
        'display_name' => 'string',
        'user' => 'array',
        'user.*' => 'numeric',
        'permission' => 'array',
        'permission.*' => 'numeric',
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
