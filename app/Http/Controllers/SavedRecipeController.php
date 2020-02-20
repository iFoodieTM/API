<?php

namespace App\Http\Controllers;
use App\SavedRecipe;
use App\USer;

use Illuminate\Http\Request;

class SavedRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('email', $request->data_token->email)->first();
        $user_id = $user->id;
        $this->setIds($user_id,$request->recipe_id);
        return response()->json(["Success" => "guardado en favoritos"], 200);
    }
    public function setIds($recipe_id,$user_id)
    {
        $saved_recipe = new SavedRecipe;
        $saved_recipe->createFromIds($recipe_id,$user_id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::where('email', $request->data_token->email)->first();
        $user_id = $user->id;
        $saved_recipe = new SavedRecipe;
        $saved_recipe = SavedRecipe::where('user_id',$user_id)->get();
        return $saved_recipe;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::where('email', $request->data_token->email)->first();
        $user_id = $user->id;
        $saved_recipe = new SavedRecipe;
        $saved_recipe = SavedRecipe::where('user_id',$user_id)->where('recipe_id',$request->recipe_id)->first();
        $saved_recipe->delete();

        return response()->json([
                "message" => 'se ha eliminado de tus favoritos'
            ], 200);
    }
}
