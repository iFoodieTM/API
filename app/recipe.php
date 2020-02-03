<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = ['name','rating', 'time', 'difficulty','video','steps','description','photo'];

    
}
