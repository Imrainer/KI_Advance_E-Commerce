<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthControllers extends Controller
{
//<!----lOGIN---->
    function logpage()
    {   
        return view('/pages/login');
    }

    function login (request $request){

        $validator = $request->validate([
            'email' => 'required',
            'password'=>'required',
            ],[
            'email.required' => 'Email Harus Diisi',
            'password.required'=>'Password Harus Diisi']);

        $email = $request->input('email');
        $password = $request->input('password'); 
        $admin = Admin::where('email', $email)->first();
                
        if ($admin && password_verify($password, $admin->password)) {
            session()->put('id',[
                'id' => $admin->id,
                'name' => $admin->name,
                'email'=>$admin->email,
                'phone' => $admin->phone,
                'photo'=>$admin->photo,
            ]);

        return redirect('/dashboard')->with('success','Selamat Datang Kembali Admin ' . $admin->name);
        } else {
        return redirect('/')->with('error', 'Invalid email or password');
        }
    }

// <!----LOGOUT----!>
    function logout()
    {
        session()->flush();
    
        return redirect('/')->with('success','Berhasil Logout');
    }

}
