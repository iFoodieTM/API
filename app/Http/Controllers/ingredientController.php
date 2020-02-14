<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;
use App\Helpers\Token;
use Illuminate\Support\Facades\Storage;

class ingredientController extends Controller
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
        $ingredient = new Ingredient;

        if (!$ingredient->ingredient_exists($request->name))
        {
            $ingredient->create_ingredient($request);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingredients = Ingredient::all();
        return response()->json(["Success" => $ingredients]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $ingredient = User::where('name', $request->name)->first();

        if (isset($ingredient)) 
        {

            if ($ingredient->name != $request->new_name) 
            {
                $ingredient->name = $request->new_name;
                $ingredient->update();
            }

        }else{
            return response()->json(["error" => 'el ingrediente no existe'], 400);
        }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
     
        $ingredient = User::where('name', $request->name)->first();

        $ingredient->delete();

        return response()->json([
                "message" => 'el ingrediente ha sido eliminado'
            ], 200);
    }
}
