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

        $recipeHasIngrecient->recipe_id = $id_recipe;
        $recipeHasIngrecient->ingredient_id = $id_ingredient;
        $recipeHasIngrecient->save();
        
    }

    public function getIdIngredients($id_recipe){

    	$ingredientsID = self::where('recipe_id',$id_recipe)->get();
		return $ingredientsID;
    }
    Public function delete_from_recipe($recipe_id)
    {
        $recipe_ingredients= self::where('recipe_id', $recipe_id)->get();

        foreach ($recipe_ingredients as $key => $recipe_ingredient) {
            $recipe_ingredient->delete();
        }
    }
}
