<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartControllers extends ApiController
{
  // <!--MENAMPILKAN PRODUCT--!>
  public function read()
  {   $userId = Auth::user()->id;
      $cart = Cart::where('created_by', $userId)->get();
 
     $formattedCart = $cart->map(function ($cart) {

         $cart->created_at_formatted = date('Y-m-d H:i:s', strtotime($cart->created_at));
         $cart->updated_at_formatted = date('Y-m-d H:i:s', strtotime($cart->updated_at));

         $photo = $cart->photo_thumbnail;
         if ($photo === null) {
             $cart->photo_thumbnail= null;
         } else {
             $cart->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photo;
         }

        //  $categoryName = Cart::where('id', $cart->categories_id)->value('category');
        //  $cart->categories_name = $categoryName;

         return $cart;
     });

     return Api::createApi(200, 'success', $cart);
 }


  // <!---MEMBUAT PRODUCT---!>
  public function create(Request $request)
  {  $userId = Auth::id();
      $cart=[
          'product_id'=>$request->product_id,
          'quantity'=>$request->quantity,
          'created_by'=>$userId,
      ];

      $cart['id'] = Str::uuid()->toString();
      
      Cart::create($cart);
      return Api::createApi(200, 'successfully created product', $cart);
  }

  // <!---MENGEDIT PRODUCT--!>
  public function edit(Request $request, $uuid)
  {   $userId = Auth::id();
      $cart = Cart::findOrFail($uuid);
        
    // Check if the user is authorized to edit this cart
      if ($cart->created_by !== $userId) {
          return Api::createApi(403, 'Unauthorized access', null);
        }

       $cart = Cart::findOrFail($uuid);

       if ($request->input('product_id')) {
           $product_id = $request->input('product_id');
       } else {
           $product_id = $cart['product_id'];
       }

       if ($request->input('quantity')) {
           $quantity = $request->input('quantity');
       } else {
           $quantity = $cart['quantity'];
       }
       
       $cart->update([
          'product_id'=>$product_id,
          'quantity'=>$quantity,
       ]);

      return Api::createApi(200, 'successfully updated cart', $cart);

  }

  // <!---MENGHAPUS PRODUCT--!>
  public function delete(Request $request, $id)
  {   $userId = Auth::id();
      $cart = Cart::findOrFail($id);

      if ($cart->created_by !== $userId) {
        return Api::createApi(403, 'Unauthorized access', null);
      }

      $cart->delete();

      return Api::createApi(200, 'product successfully deleted');
  }

}
