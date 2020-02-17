<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeHasIngredient extends Model
{
    protected $table = 'recipe_has_ingredients';
    protected $fillable = ['id','recipe_id','ingredient_id'];


    public function createFromIds($id_recipe,$id_ingredient)
    {

        $recipeHasIngrecient = new RecipeHasIngredient;

        $recipeHasIngrecient->name = $id_recipe;
        $recipeHasIngrecient->name = $id_ingredient;
        $recipeHasIngrecient->save();
        
    }
}
