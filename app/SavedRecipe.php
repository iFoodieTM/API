<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedRecipe extends Model
{
    protected $table = 'saved_recipes';
    protected $fillable = ['id','user_id','recipe_id'];

    public function createFromIds($recipe_id,$user_id)
    {

        $saved_recipe = new SavedRecipe;
        $saved_recipe->recipe_id = $recipe_id;
        $saved_recipe->user_id = $user_id;
        $saved_recipe->save();
        
    }

}
