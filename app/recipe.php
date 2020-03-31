<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
        /*if ($request->photo != NULL)
            {
                    //putFileAs(carpeta donde se guarda, la foto, nombre con el que se guarda)
                $photo = Storage::putFileAs('public/Recipes', new File($request->photo), "$user->id$recipe->name.jpg");
                $recipe->photo = $photo;
            }*/

        $recipe->save();
        $recipe_id = $recipe->id;

        //var_dump($recipe_id);exit;
        //$new_recipe = self::where('name' ,$request->name)->where('time', $request->time)->where('difficulty', $request->difficulty)->where('description', $request->description)->where('video', $request->video)->where('photo', $request->photo)->first();

        return $recipe_id;
    }
    public function setPhoto($request){

        $user = User::where('email', $request->data_token->email)->first();

        $recipe_id = intval($request->recipe_id);
        var_dump(intval($request->recipe_id));exit();
        $recipe = recipe::where('id',$recipe_id)->first();

        if ($request->photo != NULL)
            {
                    //putFileAs(carpeta donde se guarda, la foto, nombre con el que se guarda)
                $photo = Storage::putFileAs('public/Recipes', new File($request->photo), "$user->id$recipe->name.jpg");
                $recipe->photo = $photo;
            }

        $recipe->update();


    }



}
