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


use App\Http\Requests;
use Validator;
use URL;
use Redirect;
use Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;



class OrderController extends Controller
{
    private $_api_context;
   
    public function paypal_config()
    {
            
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

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



    public function paypalPayment(Request $request)
    {
        $payment_count = $request->amount;
        $this->paypal_config();
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName('Product 1')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
               ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Enter Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status',[
            'payment_count' => $payment_count
        ]))
                      ->setCancelUrl(URL::route('status',[
                        'payment_count' => $payment_count
                      ]));

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));   
            
            
        try {
            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                view('payment.paypal',[
                    'payment_count' => $payment_count
                ]);                
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                view('payment.paypal',[
                    'payment_count' => $payment_count
                ]);               
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {            
            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
        
    	return Redirect::route('/cart/paypalstatus');
    }

    public function getPaymentStatus(Request $request)
    {   $payment_count = $request->payment_count;
        $payment_id = Session::get('paypal_payment_id');

        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return view('payment.paypal',[
                'payment_count' => $payment_count
            ]);
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {         
            \Session::put('success','Payment success !!');
            view('payment.paypal',[
                'payment_count' => $payment_count
            ]);;
        }

        \Session::put('error','Payment failed !!');
		view('payment.paypal',[
            'payment_count' => $payment_count
        ]);;
    }

    
}
