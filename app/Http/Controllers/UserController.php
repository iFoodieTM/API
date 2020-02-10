<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Helpers\Token;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        $user = new User();
        if (!$user->userExists($request->email)) {
            $user->menu = Storage::url($request->menu);

            if ($request->rol == 3) {
                $user->create_admin($request);
                return $this->login($request);
            }
    
            if (((isset($user->menu))&& ($request->rol != 3))||($request->rol == 2)) {
                $user->create_restaurant($request);
                return $this->login($request);
            }
    
            if (((!isset($user->menu))&& ($request->rol != 3))||($request->rol == 1)) {
                $user->rol = 1;
                $user->create($request);
                return $this->login($request);

            } else {
                return response()->json(["Error" => "No se pueden crear usuarios con el mismo email o con el email vacío"], 400);
            }
        }
    }

    public function login(Request $request){
        
        $data_token = ['email'=>$request->email];
        
        $user = User::where($data_token)->first();  
       
        if ($user!=null) {       
            if($request->password == decrypt($user->password))
            {       
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }   
        }     
        return response()->json(["Error" => "No se ha encontrado"], 401);
    }

    public function recoverPassword (Request $request){

        $user = User::where('email',$request->email)->first();  
        if (isset($user)) {   
            $newPassword = self::randomPassword();
            self::sendEmail($user->email,$newPassword);
            
                $user->password = encrypt($newPassword);
                $user->update();
            
            return response()->json(["Success" => "Se ha restablecido su contraseña, revise su correo electronico."]);
        }else{
            return response()->json(["Error" => "El email no existe"]);
        }
    }

    public function sendEmail($email,$newPassword){
        $para      = $email;
        $titulo    = 'Recuperar contraseña de ifoodie';
        $mensaje   = 'Se ha establecido "'.$newPassword.'" como su nueva contraseña.';
        mail($para, $titulo, $mensaje);
    }
    
    public function randomPassword() {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = User::all();
        return response()->json(["Success" => $user]);
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
        $user = user::where('email',$request->data_token->email)->first();
        if (isset($user)) {
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_name = $request->user_name;
            $user->password = $request->password;
            $user->photo = Storage::url($request->photo);

            if($request->email != $user->email){
                $user->update();
                return response()->json(["Success" => "Se ha modificado el usuario."], 200);
            }
            if($request->user_name != $user->user_name){
                $user->update();
                return response()->json(["Success" => "Se ha modificado el usuario."]);
            }
            if($request->password != $user->password){
                $user->update();
                return response()->json(["Success" => "Se ha modificado el usuario."]);
            }   
            if($request->email == $user->email || $request->user_name == $user->user_name || $request->password == $user->password){
                return response()->json(["Error" => "No se puede modificar el usuario"]);
            }   
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
        $email = $request->email;
        $user = User::where('email', $email)->first();

        $user->delete();

            return response()->json([
                "message" => 'el usuario ha sido eliminado'
            ], 200);
    }
}
