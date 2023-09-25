<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Photo_Carousel;
use App\Helpers\Api;
use Illuminate\Support\Str;

class CarouselControllers extends ApiController
{
      // <!--MENAMPILKAN CAROUSEL--!>
      public function index()
      {   $carousel = Photo_Carousel::get();
  
          return Api::createApi(200, 'success', $carousel);
      }
  
      // <!--MENAMPILKAN CAROUSEL BY ID--!>
      public function byId($uuid)
      {   $carousel = Photo_Carousel::where('id', $uuid)->first();
  
          if (!$carousel) {
              return Api::createApi(404, 'carousel not found');
          }
  
          $carousel->created_at_formatted = date('Y-m-d H:i:s', strtotime($carousel->created_at));
          $carousel->updated_at_formatted = date('Y-m-d H:i:s', strtotime($carousel->updated_at));
  
          return Api::createApi(200, 'success', $carousel);
      }

       // <!--MEMBUAT CAROUSEL--!>

      public function create(Request $request)
        {    $validatedData = $request->validate([
                'photo' => 'nullable|image|max:3072'
            ]);
        
            $carousel = [
                'product_id' => $request->product_id,
            ];
        
            if ($request->file('photo')) {
                $photo = $request->file('photo')->store('product-carousel_picture');
                $carousel['photo'] = $photo;
            }
        
            $carousel['id'] = Str::uuid()->toString();
            
            Photo_Carousel::create($carousel);
            return Api::createApi(200, 'successfully created carousel', $carousel);
        }
        

    
    // <!---MENGEDIT CAROUSEL--!>
    public function edit(Request $request, $uuid)
    {   
        $carousel = Photo_Carousel::findOrFail($uuid);
        $validatedData = $request->validate([
            'photo_thumbail' => 'nullable|image|max:3072'
            ]);
       
        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('product-thumbnail_picture');
        } else {
            $photo = $carousel['photo'];
        }

        if ($request->input('product_id')) {
            $product_id = $request->input('product_id');
        } else {
            $product_id = $product['product_id'];
        }

        $carousel->update([
            'product_id'=>$product_id,
            'photo' => $photo
            
        ]);

        return Api::createApi(200, 'successfully updated carousel', $carousel);
    }

    // <!---MENGHAPUS CAROUSEL--!>
    public function delete(Request $request, $id)
    {   
        $carousel = Photo_Carousel::findOrFail($id);
    
        $carousel->delete();

        return Api::createApi(200, 'carousel successfully deleted');
    }

}
