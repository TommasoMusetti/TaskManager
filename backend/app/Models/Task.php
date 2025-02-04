<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'descrizione',
        'checked',
        'user_id'
    ];

    protected $attributes = [
        'checked' => 0, 
    ];

}
