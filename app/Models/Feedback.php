<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'role', 'message'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
