<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserHasCategory;
use App\Http\Controllers\CategoryController;

class UserHasCategoryController extends Controller
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

    public function setIds($id_user,$id_category)
    {
        $userHasCategory = new UserHasCategory;
        $userHasCategory->createFromIds($id_user,$id_category);
    }
    public function getCategories($id_user){
        
        $categoryController = new CategoryController();
        $categories = $categoryController->getCategories();
        $categoryFromUser = array();

        $categoriesID = new UserHasCategory();
        $categoriesID = $categoriesID->getIdCategories($id_user);
        
        foreach ($categoriesID as $key => $ids) {
            
            foreach ($categories as $key => $category) {
                
                if ($ids->category_id == $category->id) {
                    
                     array_push($categoryFromUser, $category);
                     
                }               
            }
        }
             
        return $categoryFromUser;
    }


    public function getUsers($category_id)

    {
        $usersHasCategory = new UserHasCategory;

        $usersHasCategory = UserHasCategory::where('id_category', $category_id)->get();

        if (isset($rusersHasCategory)) {
            
        $users_ids = array();

        foreach ($usersHasCategory as $key => $userHasCategory) {

            array_push($users_ids, $userHasCategory->user_id);

        }

            return $users_ids;

        
        }else{

        return null;

        }


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
