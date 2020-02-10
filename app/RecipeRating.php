<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeRating extends Model
{
    protected $table = 'recipes_ratings';
    protected $fillable = ['id','value','user_id','recipe_id'];
}