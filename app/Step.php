<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{

    protected $table = 'steps';
    protected $fillable = ['id','step_number','instructions','recipe_id'];


    public function create_step($request)
    {
        //$recipe = recipe::where('id',$request->recipe_id)->first();
        $step = new Step;
        $step->step_number = $request->step_number;
        $step->instructions = $request->instructions;
        $step->recipe_id = $request->recipe_id;
        $step->save();

    }

    public function recipe_steps($recipe_id)
    {

        $recipe_steps = self::where('recipe_id',$recipe_id)->get();

        return $recipe_steps;
       // return response()->json([ $recipe_steps], 200);

    }

}

