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

class CityControllers extends Controller
{
      // <!--MENAMPILKAN City--!>
      public function index(request $request)
      {  
         $admin = session('id');
         $admin = Admin::where('id', $admin)->first();
         $province = Province::all();
         $city = City::with('province')->get();   
 
         if($request->has('search')){
             $city = City::where('city', 'LIKE', '%' .$request->search.'%')->paginate(5);
         } else {
             $city = City::paginate(5);
         }
          return view ('pages/City',compact(['admin','city','province']));
      }
  
      // <!--MENAMPILKAN CITY BY ID--!>
      public function byId($uuid)
      {  $city = City::findOrFail($uuid);
  
          if (!$city) {
             return view('pages/CityById')->with('failed','City tak ditemukkan ');
          }
  
          return view ('page/City',compact(['city']));
      }
  
      // <!---MEMBUAT CITY---!>
      public function create(Request $request)
      {
        $city=[
            'city'=>$request->city,
            'province'=>$request->province,
        ];
        $city['id'] = Str::uuid()->toString();

        City::create($city);
          return redirect('/city')->with('city baru berhasil ditambahkan');
      }
      
      // <!---MENGEDIT CITY--!>
 
      public function editpage($uuid)
     {   
         $city = City::find($uuid);
         $province = Province::all();
         return view('/pages/CityEdit',compact(['city','province']));
     }
 
      public function edit(Request $request, $uuid)
      {   
        $data = City::find($uuid);
        $data->update([
            'city' =>($request->input('city')),
            'province'=>($request->input('province'))
        ]);
          return redirect('/city')->with('city berhasil diperbarui');
  
      }
  
      // <!---MENGHAPUS CITY--!>
      public function delete(Request $request, $id)
      {   
          $city = City::findOrFail($id);
      
          $city->delete();
  
          return redirect('/city')->with('city berhasil dihapus');
      }
  
}
