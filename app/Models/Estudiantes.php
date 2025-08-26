<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{
    protected $table = 'estudiante';
    protected $fillable =[
        'name',
        'email',
        'phone'
    ];


    
}
