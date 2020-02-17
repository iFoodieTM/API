<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = ['id','name','rating', 'time', 'difficulty','video','description','photo','user_id'];



    public function create_recipe($request)
    {

        $recipe = new recipe;

        $check_photo = Storage::url($request->photo);

        $user = User::where('email', $request->data_token->email)->first();

        $recipe->user_id = $user->id;
        $recipe->name = $request->name;
        $recipe->time = $request->time;
        $recipe->difficulty = $request->difficulty;
        $recipe->description = $request->description;
        $recipe->video = $request->video;
        $recipe->rating = $request->rating;

        if(isset($check_photo)){
        
            $recipe->photo = Storage::url($request->photo);
            }else{ 
        
                     $recipe->photo = "fotoprueba.png";               
                 }

        $recipe->save();
    }

    public function recipe_exist($id){


    }



}
