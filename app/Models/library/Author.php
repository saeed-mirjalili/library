<?php

namespace App\Models\library;

use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory,SoftDeletes,HasRules;

    protected $guarded=[];

    protected static $rules = [
        'name' => 'required|string',
        'categories' => 'array',
        'categories.*' => 'numeric'
    ];

    public function books() {
        return $this->hasMany(Book::class);
    }
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
