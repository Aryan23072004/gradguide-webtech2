<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    ## Test coment added to check git connection
    protected $fillable = ['user_id', 'post_id', 'content'];
}
