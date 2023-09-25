<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Review;
use App\Helpers\Api;
use App\Models\User;
use App\Models\Product;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HistoryControllers extends ApiController
{
    public function index(){
        $userId = Auth::user()->id;
        $history= History::where('created_by', $userId)->get();
        
        return Api::createApi(200, 'success', $history);
    }

    public function delete(Request $request, $id)
  {   $userId = Auth::id();
      $history = History::findOrFail($id);

      if ($history->created_by !== $userId) {
        return Api::createApi(403, 'Unauthorized access', null);
      }

      $history->delete();

      return Api::createApi(200, 'history successfully deleted');
  }
}
