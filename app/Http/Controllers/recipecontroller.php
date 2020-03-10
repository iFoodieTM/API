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
use App\User;
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

        $recipe_id = $recipe->create_recipe($request);

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
        $recipeHasCategory = new RecipeHasCategory();

        foreach ($categories as $key => $cat) {
            $id_category = $category->get_id_category($cat);
            if ($id_category != false) {                
                print('Categoria - ID receta - ID categoria <br>');
                print($cat. '-'. $recipe_id .'-'.$id_category.' <br>');
                $recipeHasCategory->createFromIds($recipe_id,$id_category);
            }
        }


        $step = new Step();
        $steps = $request->steps;

        foreach ($steps as $key => $st) {
            print('nºPaso - Paso - ID receta <br>');
            print($ing. '-'. $recipe_id .'-'.$recipe_id.' <br>');
            $step->createStep(($key+1),$st,$recipe_id);
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
        $recipe_category = $RecipeHasCategoryController->getCategories($request->recipe_id);

        return response()->json(["recipe"=>$recipe,"ingredientes" => $recipe_ingredient, "pasos" => $recipe_steps,"category"=>$recipe_category], 200);
    }    

    public function showAll(){

        $recipe= new recipe;
        $recipes = recipe::all();

        return response()->json($recipes, 200);
    }
    public function showAllFromUser(Request $request){

        $recipe= new recipe;
        $recipes = recipe::where('user_id',$request->user_id)->get();
       
        if (sizeof($recipes)!=0) {
           return response()->json($recipes, 200);
        }else{
            return response()->json("Este usuario no tiene ninguna receta creada", 401);
        }        
    }

 

    public function showFromCategory(Request $request){

        /*
            SELECT recipes.* 
            FROM recipes , recipe_has_categories 
            WHERE recipe_has_categories.category_id = 5 and recipes.id = recipe_has_categories.recipe_id
        */


        // si la respuesta esta vacia por que no haya recetas con esa categoria buscar por titulo y devolver por titulo.
    }

    public function showFromTitle(Request $request){

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

