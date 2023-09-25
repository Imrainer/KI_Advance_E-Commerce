<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Helpers\Api;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ReviewControllers extends ApiController
{
    // <!--MENAMPILKAN REVIEW SESUAI USER YANG LOGIN--!>
    public function index()
    {   $review = Review::get();

        $formattedReview = $review->map(function ($review) {
        
            $review->created_at_formatted = date('Y-m-d H:i:s', strtotime($review->created_at));
            $review->updated_at_formatted = date('Y-m-d H:i:s', strtotime($review->updated_at));

            $userName = User::where('id', $review->user_id)->value('name');
            $review->user_name = $userName;

            $userPhoto = User::where('id', $review->user_id)->value('photo');
            $review->user_photo = $userPhoto;

            return $review;
        });

        return Api::createApi(200, 'success', $review);
    }

    // <!--MENAMPILKAN REVIEW BY ID--!>
    public function byId($uuid)
    {   $review = Review::where('id', $uuid)->first();
    
            $userName = User::where('id', $review->user_id)->value('name');
            $review->user_name = $userName;

            $userPhoto = User::where('id', $review->user_id)->value('photo');
            $review->user_photo = $userPhoto;

        $review->created_at_formatted = date('Y-m-d H:i:s', strtotime($review->created_at));
        $review->updated_at_formatted = date('Y-m-d H:i:s', strtotime($review->updated_at));

        return Api::createApi(200, 'success', $review);
    }

       // <!---MEMBUAT REVIEW---!>
       public function create(Request $request)
       {   $userId = Auth::id();

           $review=[
               'star'=>$request->star,
               'content'=>$request->content,
               'product_id'=>$request->product_id,
               'user_id'=> $userId,
           ];
   
           $review['id'] = Str::uuid()->toString();
           
           Review::create($review);
           return Api::createApi(200, 'successfully created review', $review);
       }
   
       // <!---MENGEDIT REVIEW--!>
       public function edit(Request $request, $uuid)
       {   $userId = Auth::id();

           $review = Review::findOrFail($uuid);
        
        // Check if the user is authorized to edit this review
          if ($review->user_id !== $userId) {
              return Api::createApi(403, 'Unauthorized access', null);
            }

           $review = Review::findOrFail($uuid);
   
           if ($request->input('star')) {
               $star = $request->input('star');
           } else {
               $star = $review['star'];
           }
   
           if ($request->input('content')) {
               $content = $request->input('content');
           } else {
               $content = $review['content'];
           }
   
           if ($request->input('product_id')) {
               $product_id = $request->input('product_id');
           } else {
               $product_id = $review['product_id'];
           }
           
           $review->update([
              'star'=>$star,
              'content'=>$content,
              'product_id'=>$product_id,
           ]);

   
           return Api::createApi(200, 'successfully updated review', $review);
   
       }
   
       // <!---MENGHAPUS REVIEW--!>
       public function delete($uuid)
       {   $userId = Auth::id();

            $review = Review::findOrFail($uuid);
     
        // Check if the user is authorized to edit this review
        if ($review->user_id !== $userId) {
            return Api::createApi(403, 'Unauthorized access', null);
            }

           $review = Review::findOrFail($uuid);
       
           $review->delete();
   
           return Api::createApi(200, 'review successfully deleted');
       }
   
}
