<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Catalogue;
use App\Models\Province;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProvinceControllers extends Controller
{
     // <!--MENAMPILKAN PROVINCE--!>
     public function index(request $request)
     {  
        $admin = session('id');
        $admin = Admin::where('id', $admin)->first();

        $province = Province::all();

        if($request->has('search')){
            $province = Province::where('name', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $province = Province::paginate(5);
        }
         return view ('pages/Province',compact(['admin','province']));
     }
 
     // <!--MENAMPILKAN PROVINCE BY ID--!>
     public function byId($uuid)
     {  $province = Province::findOrFail($uuid);
 
         if (!$province) {
            return view('pages/ProvinceById')->with('failed','Province tak ditemukkan ');
         }
 
         return view ('page/Province',compact(['province']));
     }
 
     // <!---MEMBUAT PROVINCE---!>
     public function create(Request $request)
     {
       $province=[
           'province'=>$request->province,
       ];
       $province['id'] = Str::uuid()->toString();

       Province::create($province);
         return redirect('/province')->with('province baru berhasil ditambahkan');
     }
     
     // <!---MENGEDIT PROVINCE--!>

     public function editpage($uuid)
    {   
        $province = Province::find($uuid);
        return view('/pages/ProvinceEdit',compact(['province']));
    }

     public function edit(Request $request, $uuid)
     {   
       $data = Province::find($uuid);
       $data->update([
           'province'=>($request->input('province'))
       ]);
         return redirect('/province')->with('province berhasil diperbarui');
 
     }
 
     // <!---MENGHAPUS PROVINCE--!>
     public function delete(Request $request, $id)
     {   
         $province = Proince::findOrFail($id);
     
         $province->delete();
 
         return redirect('/province')->with('province berhasil dihapus');
     }
 
}
