<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];

    public function books() {
        return $this->hasMany(Book::class);
    }
    public function authors() {
        return $this->belongsToMany(Author::class);
    }
}
