@extends('layouts.app')

@section('content')
<?php  $whishlist = json_decode(Cookie::get('whishlist'))  ?>
 

 <!-- Start Wishlist  -->
 <div class="wishlist-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-main table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Unit Price </th>
                                <th>Add Item</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody v-for="(whish, index) in whishlist">
                            @if (isset($whishlist))
                                {{-- @foreach ($whishlist as $index => $item) --}}
                                <tr>
                                    <td class="thumbnail-img">
                                        <a href="#">
                                            <img class="img-fluid" :src="'/storage/' + whish.picture " alt="" />
                                        </a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="#">
                                            @{{ whish.name}}
                                        </a>
                                    </td>
                                    <td class="price-pr">
                                        <p>@{{ whish.price}} AMD</p>
                                    </td>
                                    <td class="add-pr">
                                    <a v-on:click="addtocartfromwhishlist(whish.id, index)" class="border" style="color: black; cursor: pointer;">Add to Cart</a>
                                    </td>
                                    <td class="remove-pr">
                                        <a  v-on:click="deletefromwhishlist( index)"  style=" cursor: pointer;">
                                        <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                {{-- @endforeach --}}
                            @endif
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Wishlist -->

@endsection