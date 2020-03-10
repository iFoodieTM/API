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

        $recipeHasCategory = new RecipeHasCategory;
        $recipeHasCategory->recipe_id = $id_recipe;
        $recipeHasCategory->category_id = $id_category;
        $recipeHasCategory->save();
        
    }

    public function getIdCategories($id_recipe){

    	$categoriesID = self::where('recipe_id',$id_recipe)->get();
		return $categoriesID;

    }

    Public function delete_from_recipe($recipe_id)
    {
        $recipe_categories = self::where('recipe_id', $recipe_id)->get();

        foreach ($recipe_categories as $key => $recipe_category) {
            $recipe_category->delete();
        }
    }   
}
