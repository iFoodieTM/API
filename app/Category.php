<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id','name'];


	public function create($request){

		$category = new Category
		$category->name = $request->name;
		$category->photo = $request->photo;
		$category->save();
		
}
