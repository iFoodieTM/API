<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ingredient;

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

    public function getIdIngredients($id_recipe){

    	$ingredientsID = self::where('recipe_id',$id_recipe)->get();
		return $ingredientsID;
    }
}
