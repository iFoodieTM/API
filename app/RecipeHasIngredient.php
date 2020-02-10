<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeHasIngredient extends Model
{
    protected $table = 'recipe_has_ingredients';
    protected $fillable = ['id','recipe_id','ingredient_id'];
}
