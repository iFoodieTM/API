<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = ['id','name','rating', 'time', 'difficulty','video','description','photo','user_id'];
    protected $casts = [
        'id' => 'Integer',
    ];



    public function create_recipe($request)
    {

        $recipe = new recipe;
        //storage
        $check_photo = ($request->photo);

        $user = User::where('email', $request->data_token->email)->first();

        $recipe->user_id = $user->id;
        $recipe->name = $request->name;
        $recipe->time = $request->time;
        $recipe->difficulty = $request->difficulty;
        $recipe->description = $request->description;
        $recipe->video = $request->video;
        $recipe->rating = $request->rating;

        if(isset($check_photo)){
            //storage
            $recipe->photo = ($request->photo);
            }else{ 
        
                     $recipe->photo = "fotoprueba.png";               
                 }

        $recipe->save();
        $recipe_id = $recipe->id;

        //var_dump($recipe_id);exit;
        //$new_recipe = self::where('name' ,$request->name)->where('time', $request->time)->where('difficulty', $request->difficulty)->where('description', $request->description)->where('video', $request->video)->where('photo', $request->photo)->first();

        return $recipe_id;
    }

    public function recipe_exist($id){


    }



}
