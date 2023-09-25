<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Categories;
use App\Models\Admin;
use Illuminate\Support\Str;

class CategoryControllers extends Controller
{
    public function create(Request $request)
    {   $categories=[
            'category'=>$request->category,
        ];
        $categories['id'] = Str::uuid()->toString();

        Categories::create($categories);
        return redirect('/category')->with('category baru berhasil ditambahkan');
    }

     // <!---Membaca Category--!>
     public function read(Request $request)
     {
        $admin = session('id');
        $admin = Admin::where('id', $admin)->first();

        $category = Categories::all();

        if($request->has('search')){
            $category = Categories::where('category', 'LIKE', '%' .$request->search.'%')->paginate(5);
        } else {
            $category = Categories::paginate(5);
        }
      
        return view ('pages/Category',compact(['category', 'admin']));
     }
     
      // <!---Mengedit Category--!>

      public function editpage($uuid)
      {   
          $category = Categories::find($uuid);
          return view('/pages/CategoryEdit',compact(['category']));
      }

      public function edit(request $request, $id)
      {
        $data = Categories::find($id);
        $data->update([
            'category' =>($request->input('category')),
        ]);
        
        return redirect('/category')->with('category berhasil diperbarui');
       
      }
      
    // <!---Menghapus Category--!>
     public function delete(request $request, $id)
     {  
        $data = Categories::find($id);
        $data->delete($id);
        
        return redirect('/category')->with('category berhasil diperbarui');
     }
}
