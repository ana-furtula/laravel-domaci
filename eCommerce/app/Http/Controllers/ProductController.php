<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    function index(){
        $data = Product::all();
        return view('product', ['products' => $data]);
    }

    function detail($id){
        $product = Product::find($id); 
        return view('detail',['product' => $product]);
    }

    function addToCart(Request $req){
        if($req->session()->has('user')){
            $cart = new Cart();
            $cart->user_id = $req->session()->get('user')['id'];
            //product_id poslat iz forme iz detail.blade.php 
            $cart->product_id = $req->product_id;
            $cart->save();
            return redirect('/');
        } else{
            return redirect('/login');
        }
    }



}
