<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email','user_name', 'password', 'photo'];

    public function create($request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->password = encrypt($request->password);
        $user->photo = $request->photo;
        $user->save();
    }

    public function userExists($email){
        $users = self::where('email',$email)->get();
        
        foreach ($users as $key => $value) {
            if($value->email == $email || $value->user_name == $user_name){
                return true;
            }
        }
        return false;
    }
}
