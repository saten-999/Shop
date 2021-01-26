@extends('layouts.app')

@section('content')
<div class="container" v-if="status!= ''">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10 alert alert-success w-25 align-center ">
            
            <p >  @{{ status}}</p>
        </div>
        </div>
        <div class="col-sm-1"></div>
</div>
<div class="shop-detail-box-main">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div id="carousel-example-1" class="single-product-slider carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active"> <img class="d-block w-100" src="/storage/{{ $product->picture }}" alt="First slide"> </div>
                        <div class="carousel-item"> <img class="d-block w-100" src="/storage/{{ $product->picture }}" alt="Second slide"> </div>
                        <div class="carousel-item"> <img class="d-block w-100" src="/storage/{{ $product->picture }}" alt="Third slide"> </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev"> 
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                    <span class="sr-only">Previous</span> 
                </a>
                    <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next"> 
                    <i class="fa fa-angle-right" aria-hidden="true"></i> 
                    <span class="sr-only">Next</span> 
                </a>
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-1" data-slide-to="0" class="active">
                            <img class="d-block w-100 img-fluid" src="/storage/{{ $product->picture }}" alt="" />
                        </li>
                        <li data-target="#carousel-example-1" data-slide-to="1">
                            <img class="d-block w-100 img-fluid" src="/storage/{{ $product->picture }}" alt="" />
                        </li>
                        <li data-target="#carousel-example-1" data-slide-to="2">
                            <img class="d-block w-100 img-fluid" src="/storage/{{ $product->picture }}" alt="" />
                        </li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-6">
                <div class="single-product-details">
                    <h2>{{ $product->name}}</h2>
                    <h5> <del>{{ $product->price * 2 }}AMD </del> {{ $product->price}} AMD</h5>
                    <p class="available-stock">
                        
                        
                        <p>
                            <h4>Description:</h4>
                            <p>{{ $product->description}} </p>
                            {{-- <div class="form-group quantity-box w-25">
                                <label class="control-label">Count</label>
                            <input class="form-control" value="1" min="1" max="{{$product->count}}" type="number">
                            </div>                                  --}}


                            <div class="price-box-bar">
                                <div class="cart-and-bay-btn">
                                    <a class="btn border"  v-on:click="addtocart({{$product->id}})" style="color: black;">Add to cart</a>
                                </div>
                            </div>
                            <a v-on:click="addtowhishlist({{$product->id}}) " style="cursor: pointer; color: white;" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a>
                            <div class="add-to-btn">
                                <div class="add-comp">
                                    <a class="btn border" v-on:click="addtowhishlist({{$product->id}})" style="color: black;"><i class="fas fa-heart"></i> Add to wishlist</a>
                                </div>
                                <div class="share-bar">
                                    <a class="btn " href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                    <a class="btn " href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a>
                                    <a class="btn " href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                    <a class="btn " href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a>
                                    <a class="btn " href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                </div>
                            </div>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
