<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // If you will you can change  the table fields names like this,
    // but  here is not needed
    // protected $table = 'posts';
    // PK
    // public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
