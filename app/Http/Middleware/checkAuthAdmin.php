<?php

namespace App\Http\Middleware;
use App\Helpers\Token;
use App\User;
use Closure;

class checkAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $header_token = $request->header('Authentication');

        if(isset($header_token)){

            $token = new Token();
            $data_token = $token->decode($header_token);
            
            $user = User::where('email',$data_token->email)->first();
            if(isset($user)){
                if ($user->rol == 3) {                    
                    $request->request->add(['data_token'=>$data_token]);
                    return $next($request);
                }
            }
        }               
        //var_dump('no tienes permisos de administrador, PALOMO!'); exit;
        return response()->json(["error" => "No estas autorizado"], 401);
    
        //return $next($request);
    }
}
