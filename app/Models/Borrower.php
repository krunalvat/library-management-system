<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table ='borrowers';
    
    protected $guarded = ['id'];
}
