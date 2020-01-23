<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        $user->photo = Storage::url($request->photo);
        $user->save();
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
