<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Cookie;
use Auth;
use DB;
use Carbon\Carbon;

use Stripe\Stripe;
use Stripe\Charge;
use Session;






class OrderController extends Controller
{
    

    public function index()
    {
       return view('admin.order.order-all',[
           'orders' => Order::where('status', null)->get()
       ]);
    }

    public function store(Request $request)
    {  
        if ( !is_null(Cookie::get('cart_products'))){

            $product = json_decode(Cookie::get('cart_products'));
            $data = $request->validate([
                'phone' => 'required',
                'date' => 'required|after:today',
                'money' => 'required',
                'payment' => 'required',
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
             
            $return = $this->payment($data['payment'], $data['money']);

            // $return =  back()->with('status','Ordered');
        }
        else{
            $return = redirect('home');
        }

        return $return;
        
    }
 
  
    public function destroy( $id)
    {
        $order = Order::find($id);


        foreach($order->product as $prod){
            $new_count = $prod->count - $prod->pivot->count;
            Product::find($prod->id)->update(['count' => $new_count ]);
        }
     
        $order->status = 'done';

        $order->save();

        return back();
        
    }
    private function payment($paymentmethod,$payment_count)
    {
       switch($paymentmethod){
            case 'card': 
                $return = view('payment.onlinecard',[
                    'payment_count' => $payment_count
                ]);
                break;
            case 'cash': 
                $return = redirect('/prod/cart')->with('status','Ordered');
                break;
            case 'paypal': 
                $return = view('payment.paypal',[
                    'payment_count' => $payment_count
                ]);
                break;
           }

        return $return;
        
    }


    public function cartPayment(Request $request)
    { 
        Stripe::setApiKey(env('STRIPE_SECRET'));
        Charge::create ([
                    "amount" => $request->payment_count,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Making test payment." 
            ]);
    
            Session::flash('success', 'Payment has been successfully processed.');
            
            return redirect('/prod/cart')->with('status','Ordered');
    }



   

  
    
}
