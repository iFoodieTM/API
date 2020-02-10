<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeHasTag extends Model
{
    protected $table = 'recipe_has_tags';
    protected $fillable = ['id','recipe_id','tag_id'];
}
