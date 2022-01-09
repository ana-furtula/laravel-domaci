<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|min:3',
            'price' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string|min:5',
            'gallery' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product = Product::create([
            'name' => $req->name,
            'price' => $req->price,
            'category' => $req->category,
            'description' => $req->description,
            'gallery' => $req->gallery,
        ]);
        return response()->json(['Product is created successfully.', $product]);
    }

    public function update(Request $req, Product $product)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|min:3',
            'price' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string|min:5',
            'gallery' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product->name = $req->name;
        $product->price = $req->price;
        $product->category = $req->category;
        $product->description = $req->description;
        $product->gallery = $req->gallery;

        $product->save();

        return response()->json(['Product is updated successfully.', $product]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json('Product deleted successfully');
    }

    public function getAll()
    {
        $products = Product::all();
        return response()->json($products);
    }

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
            $cart = Cart::where('user_id', $req->session()->get('user')['id'])->first();
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = $req->session()->get('user')['id'];
                $cart->save();
            }
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $req->product_id;
            $cartItem->amount = $req->input('quantity') === null ? 1 : $req->input('quantity');
            $cartItem->price = $req->product_price * $cartItem->amount;
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
        if (!$cart) {
            return 0;
        }
        return CartItem::where('cart_id', $cart->id)->count();
    }

    function cartList()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect('/login');
        }
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/');
        }
        $items = CartItem::where('cart_id', $cart->id)->get();
        if (!$items) {
            return redirect('/');
        }
        //dd($items);
        return view('cartlist', ['products' => $items]);
    }

    function removeFromCart($id)
    {
        CartItem::destroy($id);
        return redirect('cartlist');
    }

    function amountIncrease($id)
    {
        $item = CartItem::find($id);
        $item->amount = $item->amount + 1;
        $item->price = $item->price + $item->product->price;
        $item->save();
        return redirect('cartlist');
    }

    function amountDecrease($id)
    {
        $item = CartItem::find($id);
        if ($item->amount == 1) {
            CartItem::destroy($id);
        } else {
            $item->amount = $item->amount - 1;
            $item->price = $item->price - $item->product->price;
            $item->save();
        }
        return redirect('cartlist');
    }

    function orderNow()
    {
        $user = Session::get('user');
        $cart = Cart::where('user_id', $user->id)->first();
        $items = CartItem::where('cart_id', $cart->id)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        return view('cartlist', ['products' => null, 'info' => "You have successfully ordered chosen products."]);
    }
}
