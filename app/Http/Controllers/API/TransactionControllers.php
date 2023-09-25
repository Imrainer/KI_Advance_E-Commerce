<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Helpers\Api;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionControllers extends ApiController
{
    public function transaksi(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->input('product_id'));

        if ($product->stock < $request->input('quantity')) {
            return  Api::createApi(404, 'Stok produk tidak mencukupi.');
        }

        $product->stock -= $request->input('quantity');
        $product->save();

        $history = new History();
        $history->status = 'success';
        $history->product_id = $product->id;
        $history->quantity = $request->input('quantity');
        $history->created_by = Auth::id(); 
        $history->date = now(); 
        $history['id'] = Str::uuid()->toString();
        $history->save();

        return Api::createApi(200, 'success', $product);
    }

    public function transaksi_keranjang()
    {

    $cartItems = Cart::where('created_by', auth()->id())->get(); 
   
    foreach ($cartItems as $cartItem) {
       
        $product = Product::find($cartItem->product_id);

        if ($product->stock < $cartItem->quantity) {
            return Api::createApi(400, 'error', 'Stok produk tidak mencukupi.');
        }
        $product->stock -= $cartItem->quantity;
        $product->save();

       
        $history = new History();
        $history->status = 'success';
        $history->product_id = $product->id;
        $history->quantity = $product->stock;
        $history->created_by = auth()->id(); 
        $history->date = now(); 
        $history['id'] = Str::uuid()->toString();
        $history->save();

        $cartItem->delete();
    }
    return Api::createApi(200, 'success', 'Transaksi berhasil.');
    }
}
