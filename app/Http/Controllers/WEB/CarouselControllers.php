<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Catalogue;
use App\Models\Photo_Carousel;
use App\Models\Province;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CarouselControllers extends Controller
{
     // <!--MENAMPILKAN Carousel--!>
     public function index(request $request)
     {  
        $admin = session('id');
        $admin = Admin::where('id', $admin)->first();
        $catalogue = Catalogue::all();
        $carousel = Photo_Carousel::with('catalogue')->get();   
        // dd($carousel);
        if($request->has('search')){
            $carousel = Photo_Carousel::where('photo', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $carousel = Photo_Carousel::paginate(5);
        }
        
         return view ('pages/Carousel',compact(['admin','carousel','catalogue']));
     }
 
     // <!--MENAMPILKAN CAROUSEL BY ID--!>
     public function byId($uuid)
     {  $carousel = Photo_Carousel::findOrFail($uuid);
 
         if (!$carousel) {
            return view('pages/CarouselById')->with('failed','City tak ditemukkan ');
         }
 
         return view ('page/City',compact(['city']));
     }
 
     // <!---MEMBUAT CAROUSEL---!>
     public function create(Request $request)
     {
         $validatedData = $request->validate([
             'photo' => 'nullable|max:3072'
         ]);
     
         $carousel = [
             'catalogue_id' => $request->catalogue_id,
         ];
        
         if ($request->file('photo')) {
             $photo = $request->file('photo')->store('catalogue-carousel_picture');
             
             $carousel['photo'] = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' . $photo;
         }
         
         $carousel['id'] = Str::uuid()->toString();
         
         Photo_Carousel::create($carousel);
     
         return redirect('/carousel')->with('success', 'Carousel baru berhasil ditambahkan');
     }
     
     // <!---MENGEDIT CAROUSEL--!>

     public function editpage($uuid)
    {   
        $carousel = Photo_Carousel::find($uuid);
        $catalogue = Catalogue::all();
        return view('/pages/CarouselEdit',compact(['carousel','catalogue']));
    }

     public function edit(Request $request, $uuid)
     {   
        $carousels = Photo_Carousel::findOrFail($uuid);
        $validatedData = $request->validate([
            'carousel' => 'nullable|image|max:3072'
            ]);
       
        if ($request->file('carousel')) {
            $carousel = $request->file('carousel')->store('catalogue-carousel_picture');
        } else {
            $carousel = $carousels['carousel'];
        }

        if ($request->input('catalogue_id')) {
            $catalogue_id = $request->input('catalogue_id');
        } else {
            $catalogue_id = $carousel['catalogue_id'];
        }
        
        $carousels->update([
            'carousel'=>$carousel,
            'catalogue_id'=>$catalogue_id,
        ]);

        if ($request->hasfile('photo')) {
            $photo = $request->file('photo')->store('catalogue-carousel_picture');
            $carousels['photo'] = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_MyCatalogue/public/storage/' .  $photo;
        } else {
            $carousels->photo = null;
        }

         return redirect('/carousel')->with('carousel berhasil diperbarui');
 
     }
 
     // <!---MENGHAPUS CAROUSEL--!>
     public function delete(Request $request, $id)
     {   
        $carousel = Photo_Carousel::findOrFail($id);
    
        $carousel->delete();

         return redirect('/carousel')->with('carousel berhasil dihapus');
     }
 
}
