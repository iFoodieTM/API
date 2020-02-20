<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\recipe;
use App\Ingredient;
use App\RecipeHasIngredient;
use App\RecipeHasCategory;
use App\Http\Controllers\RecipeHasIngredientController;
use App\Http\Controllers\RecipeHasCategoryController;
use App\Category;
use App\Step;
use App\Helpers\Token;
use Illuminate\Support\Facades\Storage;

class recipecontroller extends Controller
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

        $recipe = new recipe();
        //$step= new step();

        // aqui falta:
        // como añadir steps a la receta
        // multiples steps

        $recipe_id = $recipe->create_recipe($request);

        //$request->request->add(['recipe_id'=>$recipe_id]);

        //$step->create_step($request);
        //$step->create_steps($request->array_steps,$recipe_id);


        $ingredients = $request->ingredients;
        $ingredient = new Ingredient();
        $recipeHasIngredient = new RecipeHasIngredient();

        foreach ($ingredients as $key => $ing) {
            $id_ingredient = $ingredient->get_id_ingredient($ing);
            print('Ingrediente - ID receta - ID ingrediente <br>');
            print($ing. '-'. $recipe_id .'-'.$id_ingredient.' <br>');
            $recipeHasIngredient->createFromIds($recipe_id,$id_ingredient);
        }


        $categories = $request->categories;
        $category = new Category();
        $recipeHAsCategory = new RecipeHasCategory();

        foreach ($categories as $key => $cat) {
            $id_category = $category->get_id_ingredient($cat);

            print('<br>Categoria - ID receta - ID categoria <br>');
            print($cat. '-'. $recipe_id .'-'.$id_category.' <br>');
            $recipeHasIngredient->createFromIds($recipe_id,$id_category);
        }
        
        
        return response()->json(["Success" => "Se ha creado la receta"], 200);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $recipe= new recipe;
        $RecipeHasIngredientController = new RecipeHasIngredientController();
        $RecipeHasCategoryController = new RecipeHasCategoryController();
        $step = new Step;

        $recipe = recipe::where('id',$request->recipe_id)->first();

        $recipe_ingredient = $RecipeHasIngredientController->getRecipes($request->recipe_id);
        $recipe_steps = $step->recipe_Steps($request->recipe_id);
        $recipe_category = $RecipeHasCategoryController->getRecipes($request->recipe_id);

        return response()->json(["recipe"=>$recipe,"ingredientes" => $recipe_ingredient, "pasos" => $recipe_steps,"category"=>$recipe_category], 200);
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
        $recipe = new recipe();

            $recipe = recipe::where('id',$request->id)->first();
            if (isset($recipe))
            {  
            $recipe->delete();
            return response()->json(["Success" => "Se ha eliminado la receta: "], 200);

        }else{

             return response()->json(["Error" => "La receta no existe."], 400);
             
        }
    }
    }

