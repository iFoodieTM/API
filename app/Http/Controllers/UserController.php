<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\UserHasCategoryController;
use App\UserHasCategory;
use App\Category;
use App\Location;
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

                case  1: // User usuario
                    if (!$user->user_name_taken($request->user_name)) {
                        $user->create($request);
                        return $this->login($request);
                    }else {
                        return response()->json(["este nombre de usuario ya esta en uso"], 401);
                    }
                    break;
                    
                   

                case 2: // User restaurante
                    $user->create_restaurant($request);
                    if ($request->categories!=null) {
                        $categories = $request->categories;
                        $category = new Category();
                        $userHasCategory = new UserHasCategory();

                        foreach ($categories as $key => $cat) {
                            $id_category = $category->get_id_category($cat);
                            if ($id_category != false) {                
                               // print('Categoria - ID receta - ID categoria <br>');
                               // print($cat. '-'. $user_id .'-'.$id_category.' <br>');
                                $userHasCategory->createFromIds($user->id,$id_category);
                            }
                        }
                    }
                    if ($request->longitude != null && $request->latitude != null ) {
                        $location = new Location();
                        $location->createLocation($user->id,$request->longitude,$request->latitude);
                    }
                    return $this->login($request);
                    break;

                case 3: // User admin
                    if (!$user->user_name_taken($request->user_name)) {
                        $user->create_admin($request);
                        return $this->login($request);
                    }else {
                        return response()->json(["este nombre de usuario ya esta en uso"], 401);
                    }
                    break;
                
                default:
                    return response()->json(["valor de rol no coincide con ninguno ya establecido"], 400);
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
        return response()->json(["No se pueden crear usuarios con el mismo email o con el email vacío"], 400);
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
                return response()->json($tokenEncoded, 201);
            }
        }
        return response()->json(["No se ha encontrado"], 401);
    }

    public function login_admin(Request $request)
    {

        $data_token = ['email'=>$request->email];
        
        $user = User::where($data_token)->first();
       
        if ($user!=null)
        {

            if($user->rol!=3)
            {

                return response()->json(["este usuario no es un usuario administrador"], 401);

            }

            if ($request->password == decrypt($user->password)) {
                $token = new Token($data_token);
                $tokenEncoded = $token->encode();
                return response()->json(["token" => $tokenEncoded], 201);
            }
        }
        return response()->json(["No se ha encontrado este usuario"], 401);
    }

    public function check_user_name (Request $request){

        $new_user_name = $request->user_name;
        
        $user = User::where('email', $request->data_token->email)->first();

        if (isset($user)) {

            $actual_user_name = $user->user_name;

                if($actual_user_name == $new_user_name){

                    return response()->json("posee el mismo user_name", 400);

                }
        }
        
       $avaliable = $user->user_name_taken($new_user_name);

        if (!$avaliable) {

            return response()->json("user_name disponible", 200);

        }else{

            return response()->json("user_name no disponible", 401);

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
            
            return response()->json(["Se ha restablecido su contraseña, revise su correo electronico."]);
        } else {
            return response()->json(["El email no existe"]);
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
        return response()->json($user);
    }

    public function show_user(Request $request)
    {

        $user = User::where('email', $request->data_token->email)->first();

        if (isset($user)){

            //$path = 'http://www.mypetsapp.es/storage/
            $path = 'http://54.226.238.184/storage/';
            if ($user->photo != null) {
                $userFoto = substr($user->photo, 7, strlen($user->photo));
                $photo = $path . $userFoto;
            }else{
                $photo = ".";
            }
            $user->photo = $photo;
            
            return response()->json($user,200);

        }

        return response()->json(["no hay usario que coincida con el email provisto"]);

    }

    public function show_users(Request $request)
    {
        $users = User::where('rol',1)->get();
        return response()->json($users,200);
    }

    public function show_admin(Request $request)
    {
        $users = User::where('rol',3)->get();
        return response()->json($users,200);
    }

    public function show_restaurant()
    {
        $users = User::where(['rol'=>2])->get();

        return response()->json($users,200);
        
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


     // esta funcion update es para usarse desde la web app edita los 3 tipos de usarios 
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
                        return response()->json(["No se puede modificar el usuario, ese user_name ya esta en uso"],400);

                    } else {
                        if ($user->rol==3||$user->rol==1) {
                            $user->user_name = $request->user_name;
                        }

                        $user->update();
                        return response()->json(["user edited"]);
                    }
                } 

                $user->update();
                return response()->json(["user edited"]);

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
                        return response()->json(["No se puede modificar el usuario, ese user_name ya esta en uso"]);

                    } else {
                        if ($user->rol==3||$user->rol==1) {
                            $user->user_name = $request->user_name;
                        }
                        
                        $user->update();
                        return response()->json(["user edited"]);
                    }
                }
                $user->update();
                return response()->json(["user edited"]);
                }

            } else {
            return response()->json(["El email no existe"]);
        }

    }


    public function update_user(Request $request){

        $user = User::where('email', $request->data_token->email)->first();

        if (isset($user)) 
        {
            $user->name = $request->name;
            if (isset($request->password)) {
                $user->password = encrypt($request->password);
            }           
            $user->user_name = $request->user_name;
            $user->update();

            return response()->json("usuario actualizado",200);
        

        }else{
                                
            return response()->json("usuario no posee token identificador",401);
        
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
                 'el usuario ha sido eliminado'
            ], 200);
    }
    // Location - metodos para gestionar la localizacion de los restaurantes
    public function deleteLocation(Request $request){
        //$location = new Location;
        $location = Location::where('id', $request->id_location)->first();
        $location->delete();

        return response()->json([
                 'La locaclizacion ha sido eliminada'
            ], 200);
    }
    public function getLocationfromUser(Request $request){
        
        $locations = Location::where('user_id',$request->data_token->email)->get();
        return $locations;        
    }
    public function addNewLocations(Request $request){
        $location = new Location;
        if ($request->locations != null) {
            foreach ($request->locations as $key => $loc) {
                $location->createLocation($request->data_token->email,$loc->longitude,$loc->latitude);
            }   
            return response()->json([
                 'Las localizaciones han sido añadidas'
            ], 200);
        }
        return response()->json([
                 'No se han podido añadir las localizaciones'
            ], 401);     
    }

    

    public function ban(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (isset($user)) {
            $user->banned = 1;
            $user->update();
            return response()->json([
                 'el usuario ha sido llevado ante la justicia'
            ], 200);
        }
        return response()->json([
             'el usuario no existe'
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
                 'haya perdon para todos'
            ], 200);
        }
        return response()->json([
            'el usuario no existe'
        ], 400);
    }
}