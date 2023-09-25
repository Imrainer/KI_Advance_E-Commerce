<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Models\Review;
use App\Models\Product;
use App\Models\Photo_Carousel;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductControllers extends ApiController
{   
    // <!--MENAMPILKAN PRODUCT--!>
    public function index()
    {   $product = Product::with('photoCarousel')->get();
    
        $formattedProduct = $product->map(function ($product) {

            $product->created_at_formatted = date('Y-m-d H:i:s', strtotime($product->created_at));
            $product->updated_at_formatted = date('Y-m-d H:i:s', strtotime($product->updated_at));

            $photo = $product->photo_thumbnail;
            if ($photo === null) {
                $product->photo_thumbnail= null;
            } else {
                $product->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photo;
            }

            $categoryName = Categories::where('id', $product->categories_id)->value('category');
            $product->categories_name = $categoryName;

            return $product;
        });

        return Api::createApi(200, 'success', $product);
    }

    //Menampilkan Product yang sedang trend
    public function byreview()
    {   $product = Product::with('photoCarousel','review')->get();

        $productsWithAverageReviewScore = [];

        $formattedProduct = $product->map(function ($product) {

            $product->created_at_formatted = date('Y-m-d H:i:s', strtotime($product->created_at));
            $product->updated_at_formatted = date('Y-m-d H:i:s', strtotime($product->updated_at));

            $photo = $product->photo_thumbnail;
            if ($photo === null) {
                $product->photo_thumbnail= null;
            } else {
                $product->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photo;
            }

            $categoryName = Categories::where('id', $product->categories_id)->value('category');
            $product->categories_name = $categoryName;

            
        $productsWithAverageReviewScore[] = [
            'product' => $product,
            'average_review_score' => $averageReviewScore,
        ];

        usort($productsWithAverageReviewScore, function ($a, $b) {
            return $b['average_review_score'] <=> $a['average_review_score'];
        });

        $sortedProducts = array_column($productsWithAverageReviewScore, 'product');

        $highestRatedProduct = $productsWithAverageReviewScore[0]['product'];


         });

        return Api::createApi(200, 'success', $highestRatedProduct);
    }

    // <!--MENAMPILKAN CATALOGUE BY ID--!>
    public function byId($uuid)
    {   $product = Product::with('photoCarousel','review')->first();

        if (!$product) {
            return Api::createApi(404, 'product not found');
        }

        $product->created_at_formatted = date('Y-m-d H:i:s', strtotime($product->created_at));
        $product->updated_at_formatted = date('Y-m-d H:i:s', strtotime($product->updated_at));

        $photo = $product->photo_thumbnail;
        if ($photo === null) {
            $product->photo_thumbnail= null;
        } else {
            $product->photo_thumbnail = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photo;
        }

        $categoryName = Categories::where('id', $product->categories_id)->value('category');
        
        $product->categories_name = $categoryName;
        
        $carousel =  $product->photoCarousel->map(function ($photoCarousel) {
            $photoCarousel->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $photoCarousel->photo; 
            return $photoCarousel;
        });
    
        $reviews = $product->review->map(function ($review) {
            $user = $review->user;
            $review->user_name = $user->name;
            $review->user_photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $user->photo; 
            return $review;
        });
        
        // $product->photoCarousel= $carousel;
        $product->review = $reviews;

        return Api::createApi(200, 'success', $product);
    }

    // <!---MEMBUAT PRODUCT---!>
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'photo_thumbnail' => 'nullable|image|max:3072'
            ]);

        $products=[
            'name'=>$request->name,
            'product_description'=>$request->product_description,
            'categories_id'=>$request->categories_id,
            'price'=>$request->price,
            'stock'=>$request->stock,
        ];

        if ($request->file('photo_thumbnail')) {
            $photo_thumbnail = $request->file('photo_thumbnail')->store('product-thumbnail_picture');
            $products['photo_thumbnail'] = $photo_thumbnail;
    }
        $products['id'] = Str::uuid()->toString();
        
        Product::create($products);
        return Api::createApi(200, 'successfully created product', $products);
    }

    // <!---MENGEDIT PRODUCT--!>
    public function edit(Request $request, $uuid)
    {   
        $product = Product::findOrFail($uuid);
        $validatedData = $request->validate([
            'photo_thumbail' => 'nullable|image|max:3072'
            ]);
       
        if ($request->file('photo_thumbnail')) {
            $photo_thumbnail = $request->file('photo_thumbnail')->store('product-thumbnail_picture');
        } else {
            $photo_thumbnail = $product['photo-thumbnail'];
        }

        if ($request->input('name')) {
            $name = $request->input('name');
        } else {
            $name = $product['name'];
        }

        if ($request->input('product_description')) {
            $product_description = $request->input('product_description');
        } else {
            $product_description = $product['product_description'];
        }

        if ($request->input('categories_id')) {
            $categories_id = $request->input('categories_id');
        } else {
            $categories_id = $product['categories_id'];
        }

        if ($request->input('price')) {
            $price = $request->input('price');
        } else {
            $price = $product['price'];
        }
    
        if ($request->input('stock')) {
            $stock = $request->input('stock');
        } else {
            $stock = $product['stock'];
        }
        
        if ($request->file('photo_thumbnail')) {
            $photo_thumbnail = $request->file('photo_thumbnail')->store('product-thumbnail_picture');
            $catalogues['photo_thumbnail'] = $photo_thumbnail;
    }

        $product->update([
            'name'=>$name,
            'product_description'=>$product_description,
            'categories_id'=>$categories_id,
            'photo_thumbnail' => $photo_thumbnail,
            'price'=>$price,
            'stock'=>$stock,
            
            
        ]);

        return Api::createApi(200, 'successfully updated product', $product);

    }

    // <!---MENGHAPUS PRODUCT--!>
    public function delete(Request $request, $id)
    {   
        $product = Product::findOrFail($id);
    
        $product->delete();

        return Api::createApi(200, 'product successfully deleted');
    }

}