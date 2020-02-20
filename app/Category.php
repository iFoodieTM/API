<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id','name','photo'];


	public function createCategory(Request $request){
		$category = new Category();
		$category->name = $request->name;
		$category->photo = $request->photo;
		$category->save();
	}


    public function categoryExists($name)
    {
        $categorys = self::where('name',$name)->get();
        
        foreach ($categorys as $key => $value) {
            if($value->name == $name){
                return true;
            }
        }
        return false;
    }

    public function  get_id_category($name){

        if (self::categoryExists($name)) {
            $category = self::where('name',$name)->first();
            return $category->id;
        }else{
            return false;
        }
        return false;

    }
/*
    public function get_id_category($name){

        if (self::categoryExists($name)) {
            $category = self::where('name',$name)->first();
            return $category->id;
        }else{
            $category = new Category;
            $category->name = $name;
            $category->save();

            $categoryCreated = self::where('name',$name)->first();
            return $categoryCreated->id;
        }
        return "Han habido errores";
    }
    */
}
