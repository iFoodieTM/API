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
Route::get('show_restaurant','UserController@show_restaurant');
Route::get('show_admin','UserController@show_admin');
Route::get('show_users','UserController@show_users');


Route::group(['middleware' => ['auth']], function (){


    Route::apiResource('recipes', 'recipecontroller');
    Route::post('show_recipe', 'recipecontroller@show');
    Route::get('showAll', 'recipecontroller@showAll');
    Route::put('update', 'UserController@update');
    Route::apiResource('Ingredient', 'ingredientController');
    Route::post('getIdIngredient', 'ingredientController@getIdIngredient');
    Route::apiResource('Step', 'StepController');
    Route::get('show_recipe_steps', 'StepController@show_recipe_steps');
    Route::apiResource('SavedRecipe', 'SavedRecipeController');
    Route::put('setIds', 'SavedRecipeController@setIds');
    Route::post('show_user','UserController@show_user');
    Route::get('show_categories', 'CategoryController@show');
    route::get('check_user_name','UserController@check_user_name');
    
});

Route::group(['middleware' => ['authAdmin']], function (){    
	Route::apiResource('category', 'CategoryController');
	Route::post('ban','UserController@ban');
	Route::post('unban','UserController@unban');
});