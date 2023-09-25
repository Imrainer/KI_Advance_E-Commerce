<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RequestRegister;
use App\Http\Requests\RequestLogin;
use App\Models\User;
use App\Helpers\Api;
use App\Traits\ResponseApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthControllers extends ApiController
{

    // <!---MIDDLEWARE---!>
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    // <!----LOGIN----!>
    public function login(RequestLogin $requestLogin)
    {   $loginType = filter_var($requestLogin->input('email_or_phone'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $requestLogin->merge([
            $loginType => $requestLogin->input('email_or_phone')
        ]);

        $credentials = $requestLogin->only($loginType,'password');
        $expiresIn = $requestLogin->input('expires_in') ?: config('jwt.ttl');

        if (!$token = $this->guard()->setTTL($expiresIn)->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'invalid phone, email dan password'
            ], 401);
        }
        return $this->respondWithToken($token);
    }
  
    //<!---REGISTER----!>
    public function register(RequestRegister $requestRegister) 
    {
        $data = $requestRegister->only(
            'name',
            'email',
            'phone', 
            'password',
            'password_confirmation'
        );
        
        $data['id'] = Str::uuid()->toString(); 

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return Api::createApi(200, 'successfully created',$data );
        
    }

    //<!----LOGOUT----!>
    public function logout() 
    {
        auth()->logout();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged out'
        ], 200);  
    }

    //<!---CARA UNTUK MELIHAT PROFIL USER YG LOGIN---!>
    public function getUserByToken()
    {
        $credentials =  auth()->user();
        $data = $credentials;

        if($data['photo']) {
        $data->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/'.$data['photo'];
        } else {
            $data->photo = null;
        }

        return response()->json([
        'status' => 200,
        'data' => $data
        ],200); 
          
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

   //<!---CARA ALTERNATIF UNTUK MELIHAT PROFIL USER YG LOGIN---!>
   protected function respondWithToken($token)
    {
        $credentials = auth()->user();
 	    $data = $credentials;
        if($data['photo']) {
           $data->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatelogue/public/storage/'.$data['photo'];
        } else {
           $data->photo = null;
        }


        $credentials['token'] = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    
        return response()->json([
            'status' => 200,
            'message' => 'successfully login',
            'data' => $credentials,
        ]);
    }

    public function salam() {
        return('Halo Dunia');
    }

}
