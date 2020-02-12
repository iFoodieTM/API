<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['id','name','email','user_name', 'password', 'photo','menu','description'];

    public function create($request){
        $user = new User;
        $user->rol = 1 ;
        $check_name = $request->name;
        $check_photo = Storage::url($request->photo);

        if(isset($check_name)){

            $user->name = $request->name;      

        }else{ 

            $user->name = "Guest";
        
        }
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->password = encrypt($request->password);
        

        if(isset($check_photo)){
                  
            $user->photo = Storage::url($request->photo);
        }else{ 

             $user->photo = "fotoprueba.png";        
        }
        $user->save();
    }

    public function create_restaurant($request){
        $user = new user;
        $user->rol = 2;  
        $check_photo = Storage::url($request->photo);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = encrypt($request->password);
        // aqui falta solucionar que sean varias fotos  para la carta del user
        //$user->menu = Storage::url($request->menu);
        $user->menu = $request->menu;
        $user->description = $request->description;

        if(isset($check_photo)){
        
    $user->photo = Storage::url($request->photo);
        }else{ 

             $user->photo = "fotoprueba.png";
        
        }
        $user->save();
    }

    public function create_admin($request){

        $user = new User;
        $user->rol = 3;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->password = encrypt($request->password);

        $check_photo = Storage::url($request->photo);

        if(isset($check_photo)){
                  
            $user->photo = Storage::url($request->photo);
                }else{ 
        
                     $user->photo = "fotoprueba.png";        
                }

        $user->save();

    }

    public function user_rol($email){
        $user = new User();
        $user = User::where('email',$email)->first(); 
        $rol = $user->rol;
        
        return $rol;
    }
    public function userExists($email){
        $users = self::where('email',$email)->get();
        
        foreach ($users as $key => $value) {
            if($value->email == $email){
                return true;
            }
        }
        return false;
    }





}
