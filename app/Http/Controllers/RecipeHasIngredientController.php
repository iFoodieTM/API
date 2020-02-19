<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecipeHasIngredient;
use App\Http\Controllers\ingredientController;

class RecipeHasIngredientController extends Controller
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

    }
    public function setIds($id_recipe,$id_ingredient)
    {
        $recipeHasIngrecient = new RecipeHasIngrecient;
        $recipeHasIngrecient->createFromIds($id_recipe,$id_ingredient);
    }
    public function getRecipes($id_recipe){
        
        $ingredientController = new ingredientController();
        $ingredients = $ingredientController->getIngredients();
        $ingredientsFromRecipe = array();

        $ingredientsID = new RecipeHasIngredient();
        $ingredientsID = $ingredientsID->getIdIngredients($id_recipe);
        
        foreach ($ingredientsID as $key => $ids) {
            
            foreach ($ingredients as $key => $ingredient) {
                
                if ($ids->ingredient_id == $ingredient->id) {
                    
                     array_push($ingredientsFromRecipe, $ingredient);
                     
                }               
            }
        }
             
        return $ingredientsFromRecipe;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
    public function destroy($id)
    {
        //
    }
}
