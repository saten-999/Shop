@extends('layouts.app')

@section('content')
<?php  $cart = json_decode(Cookie::get('cart_products'))  ?>
 <!-- Start Cart  -->

 <div class="cart-box-main" id="cart">
    <div class="container">
        <div class="row" >
            <div class="col-lg-12">
                <div class="table-main table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody v-for="(prod, index) in product">
                            
                            

                        @if (isset($cart))
                            {{-- @foreach ($cart as $item ) --}}
                                
                            <tr>
                                <td class="thumbnail-img">
                                    <a href="#">
                                <img class="img-fluid" :src="'/storage/'+ prod.picture" alt="" />
                            </a>
                                </td>
                                <td class="name-pr">
                                    <a href="#">
                                    @{{ prod.name }}
                            </a>
                                </td>
                                <td class="price-pr">
                                    <p> @{{ prod.price }} AMD</p>
                                </td>
                                <td class="quantity-box" id="app">
                                <input type="number" size="4" v-model="prod.order_count"   v-on:change="change_order_count(prod.id,index)" min="1"  :max="prod.count" step="1"  class="c-input-text qty text" ></td>
                                <td class="total-pr">  
                                    <p>@{{ prod.order_count * prod.price }}</p>
                                </td>
                                <td class="remove-pr">
                                    <a  v-on:click="deletefromcart( index)"  style=" cursor: pointer;">
                                        <i class="fas fa-times"></i>
                                        {{-- {{ isset( $s)}} --}}
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                      
                        </tbody>
                    </table>
                    <div class="d-flex text-danger">
                        <h4>Sub Total</h4>
                        <div class="ml-5 font-weight-bold" > @{{ subtotal }} </div>
                    </div>
                </div>
            </div>
        </div>
     
        

 
        <div class="row my-5">
   
            <div class="col-lg-6 col-sm-6">
                <div class="update-box ml-5">

                    <form action="cart/order" method="post">
                        @csrf
                        <div class="form-group w-50">
                            <label for="exampleFormControlInput1">Phone Number </label>
                            <input type="text" name="phone" placeholder="+374 xx xx xx" value="{{ old('phone')}}">
                          </div>
                          @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group w-50">
                            <label for="exampleFormControlInput1">Order Date </label>
                            <input type="datetime-local" name="date"  value="{{ old('date')}}" >
                          </div>
                          @error('date')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                          <div class="form-group w-50">
                            <label for="exampleFormControlInput1">Do you want Delivery?</label>
                            <input type="checkbox" name="delivery" id="deliverycheckbox" value="true" v-on:click="delivery ^= true">
                          </div>
    
                          <div class="form-group w-50"  id="address" v-show="delivery">
                            <label for="exampleFormControlInput1">Address</label>
                            <input type="text" name="address" placeholder="Erevan" value="{{ old('address')}}">
                          </div>
    
                            <input value="Order" type="submit">
                    </form>
                    
                </div>
            </div>
        </div>

        {{-- <div class="row my-5">
            <div class="col-lg-8 col-sm-12"></div>
            <div class="col-lg-4 col-sm-12">
                <div class="order-box">
                    <h3>Order summary</h3>
                    <div class="d-flex">
                        <h4>Sub Total</h4>
                        <div class="ml-auto font-weight-bold" > @{{ subtotal }} </div>
                    </div>
                    <div class="d-flex">
                        <h4>Discount</h4>
                        <div class="ml-auto font-weight-bold"> $ 40 </div>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex">
                        <h4>Coupon Discount</h4>
                        <div class="ml-auto font-weight-bold"> $ 10 </div>
                    </div>
                    <div class="d-flex">
                        <h4>Tax</h4>
                        <div class="ml-auto font-weight-bold"> $ 2 </div>
                    </div>
                    <div class="d-flex">
                        <h4>Shipping Cost</h4>
                        <div class="ml-auto font-weight-bold"> Free </div>
                    </div>
                    <hr>
                    <div class="d-flex gr-total">
                        <h5>Grand Total</h5>
                        <div class="ml-auto h5"> $ 388 </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-12 d-flex shopping-box"><a href="checkout.html" class="ml-auto btn hvr-hover">Checkout</a> </div>
        </div> --}}

    </div>
</div>
<!-- End Cart -->


@endsection