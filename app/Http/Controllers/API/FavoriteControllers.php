<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FavoriteControllers extends ApiController
{
    public function index()
  {  $userId = Auth::user()->id;
     $favorite = Favorite::where('created_by', $userId)->get();
  
      $formattedFavorite = $favorite->map(function ($favorite) {

          $favorite->created_at_formatted = date('Y-m-d H:i:s', strtotime($favorite->created_at));
          $favorite->updated_at_formatted = date('Y-m-d H:i:s', strtotime($favorite->updated_at));

          $photo = $favorite->photo_thumbnail;
          if ($photo === null) {
              $favorite->photo_thumbnail= null;
          } else {
              $favorite->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photo;
          }

          return $favorite;
      });

      return Api::createApi(200, 'success', $favorite);
  }

  // <!---MEMBUAT PRODUCT---!>
  public function create(Request $request)
  {  $userId = Auth::id();
      $favorite=[
          'product_id'=>$request->product_id,
          'created_by'=>$userId,
      ];

      $favorite['id'] = Str::uuid()->toString();
      
      Favorite::create($favorite);
      return Api::createApi(200, 'successfully created product', $favorite);
  }

  // <!---MENGEDIT PRODUCT--!>
  public function edit(Request $request, $uuid)
  {   $userId = Auth::id();
      $favorite = Favorite::findOrFail($uuid);
        
    // Check if the user is authorized to edit this favorite
      if ($favorite->created_by !== $userId) {
          return Api::createApi(403, 'Unauthorized access', null);
        }

       $favorite = Favorite::findOrFail($uuid);

       if ($request->input('product_id')) {
           $product_id = $request->input('product_id');
       } else {
           $product_id = $favorite['product_id'];
       }

       if ($request->input('quantity')) {
           $quantity = $request->input('quantity');
       } else {
           $quantity = $favorite['quantity'];
       }
       
       $favorite->update([
          'product_id'=>$product_id,
          'quantity'=>$quantity,
       ]);

      return Api::createApi(200, 'successfully updated favorite', $favorite);

  }

  // <!---MENGHAPUS PRODUCT--!>
  public function delete(Request $request, $id)
  {   $userId = Auth::id();
      $favorite = Favorite::findOrFail($id);

      if ($favorite->created_by !== $userId) {
        return Api::createApi(403, 'Unauthorized access', null);
      }

      $favorite->delete();

      return Api::createApi(200, 'product successfully deleted');
  }
}
