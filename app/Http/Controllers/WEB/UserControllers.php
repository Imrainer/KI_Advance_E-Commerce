<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserControllers extends Controller
{
    public function index (request $request)
    {   $admin = session('id');
        $admin = Admin::where('id', $admin)->first();
        $data = User::all();   
        if($request->has('search')){
            $data = User::where('name', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $data = User::paginate(5);
        }
        
        return view('pages/Dashboard',compact(['admin','data']));
    }

    function register(Request $request) {

        $validator = $request->validate([
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password'=>'required',
        'foto' => 'nullable|image|file'
        ],[
        'name|required' => 'Nama Harus Diisi',
        'email.required'=> 'Email Harus Diiisi',
        'email.unique'=> 'Email sudah terdaftar, Silahkan gunakan Email lain',
        'phone.required' => 'Nomor Telepon Harus Diisi',
        'phone.unique'=> 'Nomer Telepon sudah terdaftar, Silahkan gunakan Nomor Telepon lain',
        'password.required'=>'Password Harus Diisi']);


        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
        ];

        $data['id'] = Str::uuid()->toString(); 
        
        User::create($data);    
        return redirect('/dashboard');
    }

    function edituserpage($user_id)
    {   
        $data = User::find($user_id);
        return view('/pages/EditUser',compact(['data']));
    }
    
    function edituser(request $request, $user_id) {
    
        $data = User::find($user_id);
        $name = $request->input('name');
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:3072'
            ]);
    
        if($request->file('photo')) {
            $photo =  $request->file('photo')->store('user-profile_picture');
            User::where('id',$data['id'])->update(['photo'=>$data['photo']]);
        } else {
            $photo= $data['photo'];}
    
         $data->update([
            'name' => $name,
            'photo' => $photo
        ]);
        return redirect('/dashboard');
    }

    function delete($user_id)
    {
        $data= User::find($user_id);
        $data->delete($user_id);
        return redirect('/dashboard');
    }
}
