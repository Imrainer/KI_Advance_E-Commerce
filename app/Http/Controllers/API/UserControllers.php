<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\RequestEditPassword;
use App\Helpers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class UserControllers extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    // <---MENAMPILKAN SEMUA USER--->
    public function index ()
    {
    $users = User::all();

    foreach ($users as $user) {
        if ($user->foto) {
            $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $user->foto;
        }
    }
   return Api::createApi(200, 'success', $users);

    }
    // <---MENAMPILKAN USER BY KECUALI USER YG LOGIN--->
    public function myfriend()
    {
        $authenticatedUserId = Auth::id();
        $users = User::select('users.*','sekolah.sekolah as nama_sekolah')
            ->leftJoin('sekolah', 'users.sekolah_id', '=', 'sekolah.sekolah_id')
            ->whereNotIn('user_id', [$authenticatedUserId])
            ->get();
    
        foreach ($users as $user) {
            $total_likes = Like::where('liked_by', $authenticatedUserId)->count();
            $like = Like::where('user_id', $user->user_id)
                ->where('liked_by', $authenticatedUserId)
                ->first();

        if (!$like) {
            $like_by_you = false;
        } else {
            $like_by_you = true;
        }

        if ($user->foto) {
            $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $user->foto;
        }

        $user->like_by_you = $like_by_you;
    }

        return response()->json([
            'status' => '200',
            'data' => $users,
        ], 200);
    }

    // <---MENAMPILKAN USER BY ID--->
    public function byId ($user_id)
    {   
        $authenticatedUserId = Auth::id();
        $user = User::select('users.*','sekolah.sekolah as nama_sekolah')
            ->leftJoin('sekolah', 'users.sekolah_id', '=', 'sekolah.sekolah_id')
            ->find($user_id);

        $total_likes = Like::where('liked_by',$authenticatedUserId)->count();
        $like = Like::where('user_id',$user->user_id)->where('liked_by',$authenticatedUserId)->first();

        if(!$like) {
            $like_by_you = false;
        } else {
            $like_by_you = true;
        }

        if ($user && $user->foto) {
            $user->foto = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/' . $user->foto;
        }

        $user->total_likes = Like::where('liked_by',$user)->count();
        $user->like_by_you = $like_by_you;


        if ($user) {
            return Api::createApi(200, 'success', $user);
        } else {
            return Api::createApi(400, 'failed');
        }
    }    
    
    //<!----UPDATE----!>
    public function edit(request $request) {

        $data = Auth::user();
        $name = $request->input('name');
    
        $validatedData = $request->validate([
        'photo' => 'nullable|image|max:3072'
        ]);

        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('user-profile_picture');
        } else {
            $photo = $data['photo'];
        }

        $data->update([
            'name' => $name,
            'photo' => $photo
        ]);
        

        User::where('id',$data['id'])->update(['photo'=>$photo]);

        if($data['photo']) {
            $data->photo = 'https://magang.crocodic.net/ki/Rainer/KI_Advance_E-Commerce/public/storage/'.$data['photo'];
        } else {
            $data->photo = null;
        }

        return Api::createApi(200, 'successfully updated', $data);
    }

    function editPassword(RequestEditPassword $requestEditPassword) {
        $userId = Auth::user()->id;
        
        $user = User::where('id', $userId)->first();
        $user['password'] = Hash::make($requestEditPassword->new_password);
        $user->save();
        return Api::createApi(200, 'successfully updated password', $user);
    }
    

    //<!---DELETE---!>

    function delete($user_id){
        $data=Auth::user($user_id);
        $data->delete($user_id);
        return Api::createApi(200, 'successfully deleted');
    }

}
