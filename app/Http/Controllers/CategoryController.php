<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Category;
use App\Helpers\Token;
use Illuminate\Support\Facades\Storage;

class categoryController extends Controller
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
        $category = new Category();

        if (!$category->categoryExists($request->name)) {
            $category->createCategory($request);
            return response()->json(["Success" => "Se ha creado la categoria: ".$category->name], 200);  

        }else{

             return response()->json(["Error" => "La categoria ya existe."], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $category = Category::all();
        return response()->json(["Success" => $category],200);
    }
    public function getIdCategory(Request $request)    {
   
        $category = new Category();
        $idCategories = $category->get_id_category($request->name);
        return response()->json(["id" => $idCategories]);
    }
    public function getCategories(){

        $categorie = new Category();
        $categorie = Category::all();
        return $categorie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request){
        $category = new Category();

        if ($category->categoryExists($request->name)) {
            $category = Category::where('name',$request->name)->first();
            
            $category->photo = Storage::url($request->photo);
            $category->name = $request->new_name;                
            $category->update();
            return response()->json(["Success" => "Se ha actualizado la categoria: "], 200);    
        }else{            
             return response()->json(["Error" => "La categoria no existe."], 400);
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
        
        $category = new Category();

        if ($category->categoryExists($request->name)) {
            $category = Category::where('name',$request->name)->first();
            $category->delete();
            return response()->json(["Success" => "Se ha eliminado la categoria: "], 200);           
        }else{
             return response()->json(["Error" => "La categoria no existe."], 400);
        }
    }
}
