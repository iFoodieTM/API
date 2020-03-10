<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', 'UserController');
Route::post('store', 'UserController@store');
Route::post('login', 'UserController@login');
Route::post('login_admin', 'UserController@login_admin');
Route::post('recoverPassword','UserController@recoverPassword');


Route::group(['middleware' => ['auth']], function (){
    // Endpoints de recetas
    Route::apiResource('recipes', 'recipecontroller');
    Route::post('show_recipe', 'recipecontroller@show');
    Route::get('showAll', 'recipecontroller@showAll');
    Route::post('showAllFromUser', 'recipecontroller@showAllFromUser');
    Route::post('searchRecipe', 'recipecontroller@searchRecipe');
    // Endpoints de ingredientes
    Route::apiResource('Ingredient', 'ingredientController');
    Route::post('getIdIngredient', 'ingredientController@getIdIngredient');
    // Endpoints de pasos
    Route::apiResource('Step', 'StepController');
    Route::get('show_recipe_steps', 'StepController@show_recipe_steps');
    // Endpoints de la relacion usuario guarda receta
    Route::apiResource('SavedRecipe', 'SavedRecipeController');
    Route::put('setIds', 'SavedRecipeController@setIds');
    // Endpoints del usuario
    Route::put('update', 'UserController@update');
    Route::get('show_user','UserController@show_user');
    route::post('check_user_name','UserController@check_user_name');
    route::put('update_user','UserController@update_user');
    Route::get('show_users','UserController@show_users');
    Route::get('show_admin','UserController@show_admin');
    // Endpoints de categorias
    Route::get('show_categories', 'CategoryController@show');
    
});

Route::group(['middleware' => ['authAdmin']], function (){   

    Route::get('show_restaurant','UserController@show_restaurant');

	Route::apiResource('category', 'CategoryController');
	Route::post('ban','UserController@ban');
	Route::post('unban','UserController@unban');
});