<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Categories;
use App\Models\Catalogue;
use App\Models\City;
use App\Models\Province;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class MonitoringControllers extends Controller
{   

    public function GetSessionCount() {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);
        $sessionCount = $user->sessions()->count();

        return $sessionCount;
    }

    public function monitoring (request $request)
    {  
       $admin = session('id');
       $admin = Admin::where('id', $admin)->first();
       $userCount = User::count();
       $catalogueCount = Catalogue::count();
       $categoriesCount = Categories::count();
       $provinceCount = Province::count();
       $cityCount = City::count();
       return view('pages/Monitoring', compact('admin','userCount', 'provinceCount', 'catalogueCount','cityCount'));
    }

}
