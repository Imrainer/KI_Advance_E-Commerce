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
use App\Models\Categories;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class CatalogueControllers extends Controller
{
     // <!--MENAMPILKAN CATALOGUE--!>
     public function index(request $request)
     {  
        $admin = session('id');
        $admin = Admin::where('id', $admin)->first();

        $catalogue = Catalogue::all();   
        $province= Province::all();
        $city= City::get();
        $category= Categories::get();

        if($request->has('search')){
            $catalogue = Catalogue::where('name', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $catalogue = Catalogue::paginate(5);
        }
         return view ('pages/Catalogue',compact(['admin','catalogue','province','city','category']));
     }
 
     // <!--MENAMPILKAN CATALOGUE BY ID--!>
     public function byId($uuid)
     {  
        $admin = session('id');
        $admin = Admin::where('id', $admin)->first();
        $catalogue = Catalogue::with('city', 'province','categories')->where('id', $uuid)->firstOrFail();
        
         return view ('pages/CatalogueById',compact(['catalogue','admin']));
     }
 
     // <!---MEMBUAT CATALOGUE---!>
     public function create(Request $request)
     {
         $validatedData = $request->validate([
             'photo_thumbnail' => 'nullable|image|max:3072'
             ]);
       
         $catalogues=[
             'name'=>$request->name,
             'detail_content'=>$request->detail_content,
             'categories_id'=>$request->categories_id,
             'price'=>$request->price,
             'faciity_information'=>$request->facility_information,
             'province_id'=>$request->province_id,
             'city_id'=>$request->city_id,
             'longitude'=>$request->longitude,
             'latitude'=>$request->latitude,
             'photo_thumbnail' => null,
         ];
 
         if ($request->file('photo_thumbnail')) {
             $photo_thumbnail = $request->file('photo_thumbnail')->store('catalogue-thumbnail_picture');
             $catalogues['photo_thumbnail'] = $photo_thumbnail;
     }
 
         $catalogues['id'] = Str::uuid()->toString();
         
         Catalogue::create($catalogues);
         return redirect('/catalogue')->with('catalogue baru berhasil ditambahkan');
     }
     
     // <!---MENGEDIT CATALOGUE--!>

     public function editpage($uuid)
    {   
        $catalogue = Catalogue::find($uuid);
        $province= Province::all();
        $city= City::get();
        $category= Categories::get();
        return view('/pages/CatalogueEdit',compact(['catalogue','province','city','category']));
    }

     public function edit(Request $request, $uuid)
     {   
         $catalogue = Catalogue::findOrFail($uuid);
         $validatedData = $request->validate([
             'photo_thumbail' => 'nullable|image|max:3072'
             ]);
        
         if ($request->file('photo_thumbnail')) {
             $photo_thumbnail = $request->file('photo_thumbnail')->store('catalogue-thumbnail_picture');
         } else {
             $photo_thumbnail = $catalogue['photo-thumbnail'];
         }
 
         if ($request->input('name')) {
             $name = $request->input('name');
         } else {
             $name = $catalogue['name'];
         }
 
         if ($request->input('detail_content')) {
             $detail_content = $request->input('detail_content');
         } else {
             $detail_content = $catalogue['detail_content'];
         }
 
         if ($request->input('categories_id')) {
             $categories_id = $request->input('categories_id');
         } else {
             $categories_id = $catalogue['categories_id'];
         }
 
         if ($request->input('price')) {
             $price = $request->input('price');
         } else {
             $price = $catalogue['price'];
         }
         
         if ($request->input('facility_information')) {
             $facility_information = $request->input('facility_information');
         } else {
             $facility_information = $catalogue['facility_information'];
         }
 
         
         if ($request->input('province_id')) {
             $province_id = $request->input('province_id');
         } else {
             $province_id = $catalogue['province_id'];
         }
 
     
         if ($request->input('city_id')) {
             $city_id = $request->input('city_id');
         } else {
             $city_id = $catalogue['city_id'];
         }
         
         $catalogue->update([
             'name'=>$name,
             'detail_content'=>$detail_content,
             'categories_id'=>$categories_id,
             'photo_thumbnail' => $photo_thumbnail,
             'price'=>$price,
             'facility_information'=>$facility_information,
             'province_id'=>$province_id,
             'city_id'=>$city_id,
         ]);
 
         if($catalogue['photo_thumbnail']) {
             $catalogue->photo_thumbnail= 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/'.$catalogue['photo_thumbnail'];
         } else {
             $catalogue->photo_thumbnail = null;
         }
 
         return redirect('/catalogue')->with('catalogue berhasil diperbarui');
 
     }
 
     // <!---MENGHAPUS CATALOGUE--!>
     public function delete(Request $request, $id)
     {   
         $catalogue = Catalogue::findOrFail($id);
     
         $catalogue->delete();
 
         return redirect('/catalogue')->with('catalogue berhasil dihapus');
     }
 
 
}
