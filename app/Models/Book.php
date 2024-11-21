<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = 'books';
    
    protected $guarded = ['id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
