<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminControllers extends Controller
{     
// <!--CRUD N PAGE--!>

    public function index (request $request)
    {   $admin = session('id');
        $admin = Admin::where('id', $admin)->first();

        if($request->has('search')){
            $data = Admin::where('name', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $data = Admin::paginate(5);
        }

        return view('pages/Admin',compact(['admin','data']));
    }

    function create(request $request){
        
        $validator = $request->validate([
            'name' => 'required',
            'email'=> 'required',
            'phone' => 'required|unique:users,phone',
            'password'=>'required',
            ],[
            'name|required' => 'Nama Harus Diisi',
            'email.required'=> 'Email Harus Diiisi',
            'email.unique'=> 'Email sudah terdaftar, Silahkan gunakan Nomor Telepon lain',
            'phone.required' => 'Nomor Telepon Harus Diisi',
            'phone.unique'=> 'Nomer Telepon sudah terdaftar, Silahkan gunakan Nomor Telepon lain',
            'password.required'=>'Password Harus Diisi']);
        
        
            $data = [
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>Hash::make($request->password),
            ];
            
            Admin::create($data);    
            return redirect('/admin');
    }

    function profileadminpage()
    {  $data = session('id');
    
      $data = Admin::where('id', $data)->first();

      return view('/pages/profil',compact(['data']));
    }

    function editprofileadmin(request $request) {
    
        $data = session('id');
    
        $data = Admin::where('id', $data)->first();
        $data->update([
            'name' =>($request->input('name')),
            'email' =>($request->input('email')),
            'phone' =>($request->input('phone')),
        ]);
    
        return redirect('/profile/admin')->with('Profil berhasil diperbarui');
    }
    
    function editphotoprofil(request $request) {
    
        $data = session('id');
        $data = Admin::where('id', $data)->first();

        if($request->file('photo')) {
            $photo =  $request->file('photo')->store('admin-profile_picture');
            Admin::where('id',$data['id'])->update(['photo'=>$data['photo']]);
        } else {
            $photo= $data['photo'];}

        $data->update([
            'photo' => $photo
        ]);
       
        return redirect('/profile/admin')->with('Profil berhasil diperbarui');
    }

    function editadminpage($user_id)
    {   
        $data = Admin::find($user_id);
        return view('/pages/EditAdmin',compact(['data']));
    }

    function editadmin(request $request, $user_id) {
    
        $data = Admin::find($user_id);
        $name = $request->input('name');
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:3072'
            ]);
    
        if($request->file('photo')) {
            $photo =  $request->file('photo')->store('admin-profile_picture');
            Admin::where('id',$data['id'])->update(['photo'=>$data['photo']]);
        } else {
            $photo= $data['photo'];}
    
         $data->update([
            'name' => $name,
            'photo' => $photo
        ]);
        return redirect('/admin');
    }
    
    function delete($id)
    {
        $data= Admin::find($id);
        $data->delete($id);
        return redirect('/admin');
    }
}
