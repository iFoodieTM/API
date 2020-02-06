<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class recipe extends Model
{
    protected $table = 'recipes';
    protected $fillable = ['name','rating', 'time', 'difficulty','video','steps','description','photo','user_id','restaurant_id'];

    public function create_recipe($request)
    {

        $recipe = new recipe;

        $check_photo = Storage::url($request->photo);

        $user = User::where('email', $request->data_token->email)->first();
        $restaurant = restaurant::where('email', $request->data_token->email)->first();

        if(isset($user)){

            $recipe->user_id = $user->id;

        }

        if(isset($restaurant))
        {

            $recipe->restaurant_id = $restaurant->id;
    
        }

        $recipe->name = $request->name;
        $recipe->time = $request->time;
        $recipe->difficulty = $request->difficulty;
        $recipe->steps = $request->steps;
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
}
