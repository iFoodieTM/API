<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecipeHasCategory;
use App\Http\Controllers\CategoryController;


class RecipeHasCategoryController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function setIds($id_recipe,$id_category)
    {
        $recipeHasCategory = new RecipeHasCategory;
        $recipeHasCategory->createFromIds($id_recipe,$id_category);
    }
    public function getRecipes($id_recipe){
        
        $categoryController = new CategoryController();
        $categories = $categoryController->getCategories();
        $categoryFromRecipe = array();

        $categoriesID = new RecipeHasCategory();
        $categoriesID = $categoriesID->getIdCategories($id_recipe);
        
        foreach ($categoriesID as $key => $ids) {
            
            foreach ($categories as $key => $category) {
                
                if ($ids->category_id == $category->id) {
                    
                     array_push($categoryFromRecipe, $category);
                     
                }               
            }
        }
             
        return $categoryFromRecipe;
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
