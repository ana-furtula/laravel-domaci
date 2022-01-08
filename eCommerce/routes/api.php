<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/products', function (Request $request) {
        $products = \App\Models\Product::all();
        return $products->toJson(JSON_PRETTY_PRINT);
    });
});

// Route::get('/products', function (Request $request) {
//     $products = \App\Models\Product::all();
//     return $products->toJson(JSON_PRETTY_PRINT);
// });

Route::post('/products', function (Request $request) {
    $product = new \App\Models\Product();
    $product->name = $request['name'];
    $product->price = $request['price'];
    $product->category = $request['category'];
    $product->description = $request['description'];
    $product->gallery = $request['gallery'];
    $product->save();

    return $product->toJson(JSON_PRETTY_PRINT);
});

Route::get('/products/{id}', function (Request $request, $id) {
    $product = \App\Models\Product::find($id);
    return $product->toJson(JSON_PRETTY_PRINT);
});

Route::delete('/products/delete/{id}', function ($id) {
    $product = \App\Models\Product::find($id);
    $product->delete();

    $response = (object)['Message' => 'Obrisano', 'Value' => $product];

    return json_encode($response);
});
