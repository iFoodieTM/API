<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';
    protected $fillable = ['id','name'];

    public function create_ingredient($request)
    {

        $ingredient = new Ingredient;

        $ingredient->name = $request->name;
  
        $ingredient->save();
        
    }

    public function ingredient_exist($name)
    {
      
        $ingredients = self::where('name',$name)->get();
        
        foreach ($ingredients as $key => $value) {
            if($value->name == $name){
                return true;
            }
        }
        return false;
    }

    public function get_id_ingredient($name){

        if (self::ingredient_exist($name)) {
            $ingredient = self::where('name',$name)->first();
            return $ingredient->id;
        }else{
            $ingredient = new Ingredient;
            $ingredient->name = $name;
            $ingredient->save();

            $ingredientCreated = self::where('name',$name)->first();
            return $ingredientCreated->id;
        }
        return "Han habido errores";
    }


}
