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
            if (isset($request->rol)) {
                switch ($request->rol) {

                case  1:
                    if (!$user->user_name_taken($request->user_name)) {
                        $user->create($request);
                        return $this->login($request);
                    }else {
                        return response()->json(["Error" => "este nombre de usuario ya esta en uso"], 401);
                    }
                    break;
                    
                   

                case 2:
                    $user->create_restaurant($request);
                    return $this->login($request);
                    break;

                case 3:
                    if (!$user->user_name_taken($request->user_name)) {
                        $user->create_admin($request);
                        return $this->login($request);
                    }else {
                        return response()->json(["Error" => "este nombre de usuario ya esta en uso"], 401);
                    }
                    break;
                
                default:
                    return response()->json(["Error" => "valor de rol no coincide con ninguno ya establecido"], 400);
                    break;
                }
            } else {
                if (isset($request->menu)) {
                    $user->create_restaurant($request);
                    return $this->login($request);
                } else {
                    $user->create($request);
                    return $this->login($request);
                }
            }
        }
        return response()->json(["Error" => "No se pueden crear usuarios con el mismo email o con el email vacío"], 400);
    }

    public function login(Request $request)
    {
        $data_token = ['email'=>$request->email];
        
        $user = User::where($data_token)->first();
       
        if ($user!=null) 
        {
            if ($request->password == decrypt($user->password)) 
            {
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }
        }
        return response()->json(["Error" => "No se ha encontrado"], 401);
    }

    public function login_admin(Request $request)
    {

        $data_token = ['email'=>$request->email];
        
        $user = User::where($data_token)->first();
       
        if ($user!=null)
        {

            if($user->rol!=3)
            {

                return response()->json(["Error" => "este usuario no es un usuario administrador"], 401);

            }

            if ($request->password == decrypt($user->password)) {
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }
        }
        return response()->json(["Error" => "No se ha encontrado este usuario"], 401);
    }

    public function check_user_name (Request $request){

        $new_user_name = $request->user_name;
        
        $user = User::where('email', $request->data_token->email)->first();

        if (isset($user)) {

            $actual_user_name = $user->user_name;

                if($actual_user_name == $new_user_name){

                    return response()->json(["posee el mismo user_name", 400]);

                }
        }
        
       $avaliable = $user->user_name_taken($new_user_name);

        if (!$avaliable) {

            return response()->json(["user_name disponible", 200]);

        }else{

            return response()->json(["user_name no disponible", 401]);

        }
        
    }

    public function recoverPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (isset($user)) {
            $newPassword = self::randomPassword();
            self::sendEmail($user->email, $newPassword);
            
            $user->password = encrypt($newPassword);
            $user->update();
            
            return response()->json(["Success" => "Se ha restablecido su contraseña, revise su correo electronico."]);
        } else {
            return response()->json(["Error" => "El email no existe"]);
        }
    }

    public function sendEmail($email, $newPassword)
    {
        $para      = $email;
        $titulo    = 'Recuperar contraseña de ifoodie';
        $mensaje   = 'Se ha establecido "'.$newPassword.'" como su nueva contraseña.';
        mail($para, $titulo, $mensaje);
    }
    
    public function randomPassword()
    {
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

    public function show_user(Request $request)
    {

        $user = User::where('email', $request->data_token->email)->first();

        if (isset($user)) 
        {
            
            return response()->json($user);

        }

        return response()->jason("no hay usario que coincida con el email provisto");

    }

    public function show_users(Request $request)
    {
        $users = User::where('rol',1)->get();
        return response()->json(["Success" => $users]);
    }

    public function show_admin(Request $request)
    {
        $users = User::where('rol',3)->get();
        return response()->json(["Success" => $users]);
    }

    public function show_restaurant()
    {
        $users = User::where(['rol'=>2])->get();

        return response()->json(["Success" => $users]);
        
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
    public function update(Request $request)
    {
        $user = User::where('email', $request->data_token->email)->first();
        if (isset($user)) 
        {
            if ((isset($request->email)&&($user->rol=3))) 
            {
                $user = User::where('email', $request->email)->first();

                $user->name = $request->name;
                $user->password = encrypt($request->password);
                $user->menu = $request->menu;
                $user->description = $request->description;
                //storage
                $user->photo = $request->photo;
                
            
                if ((isset($request->user_name)&&($request->user_name != $user->user_name))||$user->rol==2) 
                {
                    $user_repeated = User::where('user_name', $request->user_name)->first();

                    if (isset($user_repeated)&&!$user->rol==2) 
                    {
                        return response()->json(["Error" => "No se puede modificar el usuario, ese user_name ya esta en uso"],400);

                    } else {
                        if ($user->rol==3||$user->rol==1) {
                            $user->user_name = $request->user_name;
                        }

                        $user->update();
                        return response()->json(["succces" => "user edited"]);
                    }
                } 

                $user->update();
                return response()->json(["succces" => "user edited"]);

            }else{

                $user->name = $request->name;
                $user->password = encrypt($request->password);
                $user->menu = $request->menu;
                $user->description = $request->description;
                $user->photo = Storage::url($request->photo);
                
            
                if ((isset($request->user_name)&&($request->user_name != $user->user_name))||$user->rol==2) 
                {
                    $user_repeated = User::where('user_name', $request->user_name)->first();

                    if (isset($user_repeated)&&!$user->rol==2) 
                    {
                        return response()->json(["Error" => "No se puede modificar el usuario, ese user_name ya esta en uso"]);

                    } else {
                        if ($user->rol==3||$user->rol==1) {
                            $user->user_name = $request->user_name;
                        }
                        
                        $user->update();
                        return response()->json(["succces" => "user edited"]);
                    }
                }
                $user->update();
                return response()->json(["succces" => "user edited"]);
                }

            } else {
            return response()->json(["Error" => "El email no existe"]);
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

    public function ban(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (isset($user)) {
            $user->banned = 1;
            $user->update();
            return response()->json([
                "message" => 'el usuario ha sido llevado ante la justicia'
            ], 200);
        }
        return response()->json([
            "message" => 'el usuario no existe'
        ], 400);
    }

    public function unban(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (isset($user)) {
            $user->banned = 0;
            $user->update();
            return response()->json([
                "message" => 'haya perdon para todos'
            ], 200);
        }
        return response()->json([
            "message" => 'el usuario no existe'
        ], 400);
    }
}