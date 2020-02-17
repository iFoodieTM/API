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

        if (!$ingredient->ingredient_exist($request->name))
        {
            $ingredient->create_ingredient($request);
            return response()->json(["Success" => "Se ha creado el ingrediente: ".$request->name], 200);
        }else{
            return response()->json(["error" => "ya existe el ingrediente: ".$request->name], 400);
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
    public function getIdIngredient(Request $request)
    {
   
        $ingredient = new Ingredient();
        $idIngredients = $ingredient->get_id_ingredient($request->name);
        return response()->json(["id" => $idIngredients]);
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
        $ingredient = Ingredient::where('name', $request->name)->first();

        if (isset($ingredient)) 
        {

            if ($ingredient->name != $request->new_name) 
            
            {
                if (!$ingredient->ingredient_exist($request->new_name)) {
                    $ingredient->name = $request->new_name;
                    $ingredient->update();
                    return response()->json(["succes" => 'el ingrediente se ha modificado'], 200);

                }else{
                    return response()->json(["error" => 'ya existe un ingrediente con ese nombre'], 400);
                }
                
            }else{
                return response()->json(["error" => 'el ingrediente ya tiene ese nombre'], 400);
            }

        }else{
            return response()->json(["error" => 'el ingrediente a modificar no existe'], 400);
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
        
        if (issset($ingredient)) {
            
            return response()->json(["message" => 'el ingrediente ha sido eliminado'], 200);
            $ingredient->delete();

        }else{

            return response()->json(["error" => 'el ingrediente a eliminar no existe'], 400);

        }

    }
}
