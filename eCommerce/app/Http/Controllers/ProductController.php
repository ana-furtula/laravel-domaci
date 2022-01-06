<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    function index()
    {
        $data = Product::all();
        return view('product', ['products' => $data]);
    }

    function detail($id)
    {
        $product = Product::find($id);
        return view('detail', ['product' => $product]);
    }

    function addToCart(Request $req)
    {
        if ($req->session()->has('user')) {
            $cart = Cart::where('user_id',$req->session()->get('user')['id'])->first();
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = $req->session()->get('user')['id'];
                $cart->save();
            }
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $req->product_id;
            $cartItem->price = $req->product_price;
            $cartItem->amount = 1;
            $cartItem->save();
            return redirect('/');
        } else {
            return redirect('/login');
        }
    }

    static function cartItemsNumber()
    {
        $userId = Session::get('user')['id'];
        $cart = Cart::where('user_id', $userId)->first();
        if(!$cart){
            return 0;
        } 
        return CartItem::where('cart_id', $cart->id)->count();
    }
}
