<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Helpers\Api;
use App\Models\Catalogue;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryControllers extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    // <!---Membuat Category--!>
    public function create(Request $request)
    {   $categories=[
            'category'=>$request->category,
        ];
        $categories['id'] = Str::uuid()->toString();

        Categories::create($categories);
        return Api::createApi(200, 'successfully created ', $categories);
    }

     // <!---Membaca Category--!>
     public function read(Request $Request)
     {
        $categories = Categories::get();
      
        return Api::createApi(200, 'successfully', $categories);
     }
     
    // <!--MENAMPILKAN NOTE BY ID--!>
    public function byId($uuid)
    {   $categories = Categories::where('id', $uuid)->first();

        if (!$categories) {
            return Api::createApi(404, 'categories not found');
        }

        return Api::createApi(200, 'success', $categories);
    }

      // <!---Mengedit Category--!>
      public function edit(request $request, $id)
      {
        $data = Categories::find($id);
        $data->update([
            'category' =>($request->input('category')),
        ]);
        
        return Api::createApi(200, 'successfully updated', $data);
       
      }
      
    // <!---Menghapus Category--!>
     public function delete(request $request, $id)
     {  
        $data = Categories::find($id);
        $data->delete($id);
        
        return Api::createApi(200, 'successfully deleted', $data);
     }

}
