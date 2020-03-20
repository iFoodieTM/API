<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHasCategory extends Model
{
    protected $table = 'user_has_categories';
    protected $fillable = ['id','user_id','category_id'];



    public function createFromIds($id_user,$id_category)
    {

        $userHasCategory = new UserHasCategory;
        $userHasCategory->user_id = $id_user;
        $userHasCategory->category_id = $id_category;
        $userHasCategory->save();
        
    }

    public function getIdCategories($id_user){

    	$categoriesID = self::where('user_id',$id_user)->get();
		return $categoriesID;

    }

    Public function delete_from_user($recipe_id)
    {
        $user_categories = self::where('user_id', $user_id)->get();

        foreach ($user_categories as $key => $user_category) {
            $user_category->delete();
        }
    }  

}
