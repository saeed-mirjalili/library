<?php

namespace App\Models\library;

use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes,HasRules;

    protected $guarded=[];

    protected static $rules =[
        'name' => 'required|string',
        'description' => 'string'
    ];

    public function books() {
        return $this->hasMany(Book::class);
    }
    public function authors() {
        return $this->belongsToMany(Author::class);
    }
}
