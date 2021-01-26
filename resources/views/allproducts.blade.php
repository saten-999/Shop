@extends('layouts.app')

@section('content')



  {{-- <!-- Start Categories  -->
  <div class="categories-shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/t-shirts-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">T-shirts</a>
                </div>
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/shirt-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">Shirt</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/wallet-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">Wallet</a>
                </div>
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/women-bag-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">Bags</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/shoes-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">Shoes</a>
                </div>
                <div class="shop-cat-box">
                    <img class="img-fluid" src="front/images/women-shoes-img.jpg" alt="" />
                    <a class="btn hvr-hover" href="#">Women Shoes</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Categories --> --}}


<div class="container mt-5">
    

    <div class="row" id="all">
        <router-link to="/all"> All </router-link>
        @foreach ($categories as $category)

            <div class="col-sm-2 text-center">
                <router-link to="/{{$category->name}}"> {{ucfirst($category->name)}}</router-link>
            </div>

        @endforeach
    
    </div>




    <router-view></router-view>
    
</div>

    





@endsection





   