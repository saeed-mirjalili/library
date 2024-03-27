<?php

namespace App\Models\library;

use App\Models\user\User;
use App\Traits\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes,HasRules;

    protected $guarded=[];

    protected static $rules = [
        'name' => 'required|string',
        'summary' => 'required|string',
        'edition' => 'required|date_format:Y',
        'author_id' => 'required|numeric',
        'category_id' => 'required|numeric',
        'book_url' => 'required|mimes:pdf'
    ];

    public function author() {
        return $this->belongsTo(Author::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
