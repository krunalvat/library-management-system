<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    protected $table ='book_borrows';
    
    protected $guarded = ['id'];


    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
