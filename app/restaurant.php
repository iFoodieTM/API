<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class restaurant extends Model
{
    protected $table = 'restaurants';
    protected $fillable = ['name','email', 'password', 'photo','menu','description'];

    public function create_restaurant($request){
        $restaurant = new restaurant;  
        $check_photo = Storage::url($request->photo);
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->password = encrypt($request->password);
        // aqui falta solucionar que sean varias fotos  para la carta del restaurante
        $restaurant->menu = Storage::url($request->menu);
        $restaurant->description= $request->description;

        if(isset($check_photo)){
        
    $restaurant->photo = Storage::url($request->photo);
        }else{ 

             $restaurant->photo = "fotoprueba.png";
        
        }
        $restaurant->save();
    }

    public function restaurantExists($email){
        $restaurants = self::where('email',$email)->get();
        
        foreach ($restaurants as $key => $value) {
            if($value->email == $email){
                return true;
            }
        }
        return false;
    }
}
