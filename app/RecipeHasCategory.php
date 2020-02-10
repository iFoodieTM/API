<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeHasCategory extends Model
{
    protected $table = 'recipe_has_categories';
    protected $fillable = ['id','recipe_id','category_id'];
}
