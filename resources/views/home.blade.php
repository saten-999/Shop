@extends('layouts.app')

@section('content')


<div class="cover-slides">
    <div id="carouselExampleControls" class="carousel slide pl-0 pr-0" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="front/images/banner-01.jpg" alt="First slide" style="filter: brightness(0.5)">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="front/images/banner-02.jpg" alt="Second slide" style="filter: brightness(0.5)">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="front/images/banner-03.jpg" alt="Third slide" style="filter: brightness(0.5)">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
   
</div>





<div style="position: relative; margin-top: 5%; ">

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <p class="h1 text-center">Latest Add Products</p>
            </div>
        </div>
    </div>
    
    <div  class="products-box  d-flex justify-content-center" id="shop" >
              
            <div class="row special-list " style="width: 85%">
                
    
                @foreach ($products as $product)
                    
                <div class="col-lg-3 col-md-6 special-grid best-seller">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            {{-- <div class="type-lb">
                                <p class="sale">Sale</p>
                            </div> --}}
                        <img src="storage/{{ $product->picture}}" class="img-flu" alt="Image">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="product/view/{{ $product->id}}" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a v-on:click="addtowhishlist({{$product->id}}) " style="cursor: pointer; color: white;" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                </ul>
                                <a class="cart"  v-on:click="addtocart({{$product->id}})" style="cursor: pointer">Add to Cart</a>
                                {{-- <button class="cart">Add to Cart</button> --}}
                            </div>
                        </div>
                        <div class="why-text">
                            <h4>{{ $product->name}}</h4>
                            <h5> {{ $product->price}} AMD</h5>
                        </div>
                    </div>
                </div>
                    {{-- {{$_COOKIE['prod']}} --}}
    
                @endforeach
                
               
                
                {{-- {{ $products->links() }} --}}
                
            </div>
        
    </div>

</div>


@endsection
