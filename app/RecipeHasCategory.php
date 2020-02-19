<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class RecipeHasCategory extends Model
{
    protected $table = 'recipe_has_categories';
    protected $fillable = ['id','recipe_id','category_id'];



    public function createFromIds($id_recipe,$id_category)
    {

        $recipeHasCategory = new RecipeHasIngredient;

        $recipeHasCategory->name = $id_recipe;
        $recipeHasCategory->name = $id_ingredient;
        $recipeHasCategory->save();
        
    }

    public function getIdCategories($id_recipe){

    	$categoriesID = self::where('recipe_id',$id_recipe)->get();
		return $categoriesID;

    }
}
