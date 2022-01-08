@extends('master')
@section('content')
<div class="container" style="height: 60rem;">
    <div class="row">
        <a href="/">
            <h4>Go back</h4>
        </a>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <img class="detail-image" src="{{$product['gallery']}}">
        </div>
        <div class="col-sm-6">
            <h3> <b>{{$product['name']}}</b></h3>
            <h4><b>Price:</b> {{$product['price']}}</h4>
            <h4><b>Details:</b> {{$product['description']}}</h4>
            <h4><b>Category:</b> {{$product['category']}}</h4>
            <br><br>
            <form action="/add_to_cart" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{$product['id']}}">
                <input type="hidden" name="product_price" value="{{$product['price']}}">
                <h4>
                    <label for="quantity">Quantity: </label>
                    <input type="number" id="quantity" name="quantity" min="1">
                </h4>
                <button class="btn btn-primary">Add to Cart</button>
            </form>
            <br><br>
        </div>
    </div>
</div>
@endsection