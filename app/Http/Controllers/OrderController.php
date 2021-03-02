<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Cookie;
use Auth;
use DB;
use Carbon\Carbon;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.order.order-all',[
           'orders' => Order::where('status', Null)->get()
       ]);
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
        if ( !is_null(Cookie::get('cart_products'))){

            $product = json_decode(Cookie::get('cart_products'));
            $data = $request->validate([
                'phone' => 'required',
                'date' => 'required|after:today',
                // 'delivery' => 'required',
                'address' => 'max:255',
            ]);                                                               

            $data['user_id'] = Auth::user()->id;

            $order = Order::create($data);

            
            foreach($product as $prod ){
                $ord =[];
                $ord['order_id'] = $order->id;
                $ord['product_id'] = $prod->id;
                $ord['count'] = $prod->order_count;

                DB::table('order_product')->insert($ord);
            }
            

            Cookie::queue(Cookie::forget('cart_products'));

            $return =  back()->with('status','Ordered');
        }
        else{
            $return = redirect('home');
        }

        return $return;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
    $order = Order::find($id);


      foreach($order->product as $prod){
          $new_count = $prod->count - $prod->pivot->count;
            // if($new_count<=)
          Product::find($prod->id)->update(['count' => $new_count ]);
      }
     

        $order->status = 'done';

        $order->save();

        return back();
        
    }
}
