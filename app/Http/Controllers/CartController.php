<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Cookie;
use App\Product;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){
            return response()->json(json_decode(Cookie::get('cart_products')));
       }
        return view('cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( is_null(Cookie::get('cart_products'))){
            $added = Product::findOrFail($id);
            $added->order_count=1;

            
            $products[] = $added;

            Cookie::queue(Cookie::make('cart_products', json_encode($products))); 
        }
        else{

           $added = Product::findOrFail($id);
           $products= json_decode(Cookie::get('cart_products'));
           $added->order_count=$added->order_count + 1;
           $ka = false;

            foreach($products as $prod){
                
                if(isset($prod->order_count)){
                    
                    if($added->id == $prod->id){
                        $prod->order_count =  $prod->order_count +1;
                        $ka = true;
                    }
                }
                else{
                    $prod->order_count = 1;
                }
            }

            if($ka != true){
                $added->order_count = 1;
                array_push($products, $added);
            }
            
          
            Cookie::queue(Cookie::make('cart_products', json_encode($products)));
        }
        return count($products);
    }

    public function showvue($cart, $count){
        
        if ( !is_null(Cookie::get('cart_products'))){

           $added = Product::findOrFail($cart);
           $products= json_decode(Cookie::get('cart_products'));
           $added->order_count=$count;
           $ka = false;

            foreach($products as $prod){
                
                if(isset($prod->order_count)){
                    
                    if($added->id == $prod->id){
                        $prod->order_count =  $count;
                        $ka = true;
                    }
                }
                else{
                    $prod->order_count = $count;
                }
            }

            if($ka != true){
                $added->order_count = $count;
                array_push($products, $added);
            }
            
          
            Cookie::queue(Cookie::make('cart_products', json_encode($products)));
        }
        

        return count($products);

    }
    public function whishlist(Request $request)
    {   
        if($request->ajax()){
            return response()->json(json_decode(Cookie::get('whishlist')));
       }
        return view('whishlist');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( !is_null(Cookie::get('cart_products'))){
            $products= json_decode(Cookie::get('cart_products'));

            array_splice($products, $id,1);

            Cookie::queue(Cookie::make('cart_products', json_encode($products))); 

            return count($products)-1;
        }
    }
}
