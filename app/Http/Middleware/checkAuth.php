<?php

namespace App\Http\Middleware;
use App\Helpers\Token;
use App\User;
use Closure;

class checkAuth
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
                if ($user->banned == 0) {                    
                    $request->request->add(['data_token'=>$data_token]);
                    return $next($request);
                }else{
                    var_dump('Estas baniado, sorry, haberte portado bien'); exit;
                }
            }
        }               
        var_dump('no tienes permisos'); exit;
    
        //return $next($request);
    }
}
