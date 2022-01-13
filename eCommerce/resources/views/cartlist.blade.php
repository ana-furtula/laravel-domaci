@extends('master')
@section("content")
@if(Session::has('message'))
<div class="row">
  <div class="col-md-12">
    <p class="myInfo alert alert-info">{{ Session::get('message') }}</p>
  </div>
  @endif
  <div class="custom-product">
    <div class="col-sm-10">
      <div class="trending-wrapper">
        <h3>Your cart</h3>
        @if(!$products || count($products)<=0) <div>
          <div class="alert alert-danger" role="alert">
            No products in your cart.
          </div>
      </div>
      @else
      <a class="btn btn-success" href="/ordernow">Order Now</a> <br> <br>
      @foreach($products as $item)
      <div class=" row searched-item cart-list-devider">
        <div class="col-sm-3">
          <a href="detail/{{$item->product->id}}">
            <img class="trending-image" src="{{$item->product->gallery}}">
          </a>
        </div>
        <div class="col-sm-4">
          <div class="">
            <h2>{{$item->product->name}}</h2>
            <h5>{{$item->product->description}}</h5>
          </div>
        </div>
        <div class="col-sm-3">

          <h3>Amount: {{$item->amount}}
            <a href="/amountIncrease/{{$item->id}}"><i class="bi bi-plus-lg" style="size: 10px; border: solid gray 1px;"></i></a>
            <a href="/amountDecrease/{{$item->id}}"><i class="bi bi-dash-lg" style="size: 10px; border: solid gray 1px;"></i></a>
          </h3>
          <h3>Price: {{$item->price}}</h3>
          <a href="/removefromcart/{{$item->id}}" class="btn btn-warning">Remove from Cart</a>
        </div>
      </div>
      @endforeach
      @endif

    </div>
  </div>
</div>
@endsection