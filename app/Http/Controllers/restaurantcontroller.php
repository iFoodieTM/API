<?php

namespace App\Http\Controllers;
use App\restaurant;
use App\Helpers\Token;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class restaurantcontroller extends Controller
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
        $restaurant = new restaurant();
        if (!$restaurant->restaurantExists($request->email)){
            $restaurant->create_restaurant($request);
            return $this->login($request);

        }else{
            return response()->json(["Error" => "No se pueden crear restaurante con el mismo email o con el email vacío"], 400);
        }
    }

    public function login(Request $request){
        
        $data_token = ['email'=>$request->email];
        
        $restaurant = restaurant::where($data_token)->first();  
       
        if ($restaurant!=null) {       
            if($request->password == decrypt($restaurant->password))
            {       
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }   
        }     
        return response()->json(["Error" => "No se ha encontrado"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = restaurant::all();
        return response()->json(["Success" => $restaurant]);
    }
    public function recoverPassword (Request $request){

        $restaurant = restaurant::where('email',$request->email)->first();  
        if (isset($restaurant)) {   
            $newPassword = self::randomPassword();
            self::sendEmail($restaurant->email,$newPassword);
            
                $restaurant->password = encrypt($newPassword);
                $restaurant->update();
            
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
        $email = $request->email;
        $restaurant = restaurant::where('email', $email)->first();

        $restaurant->delete();

            return response()->json([
                "message" => 'el usuario ha sido eliminado'
            ], 200);
    }
}
