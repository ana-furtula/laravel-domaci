<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    public $table = "cart_items";

    protected $fillable = [
        'poduct_id',
        'amount',
        'price',
        'cart_id'
    ];

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
    
    public function cart(){
        return $this->belongsTo('App\Models\Cart');
    }

}
