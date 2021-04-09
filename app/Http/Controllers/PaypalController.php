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
use Config;
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



class PaypalController extends Controller
{
    private $_api_context;
   
    public function __construct()
    {
            
        $paypal_configuration = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }




    public function paypalPayment(Request $request)
    {
        $payment_count = $request->amount;
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
            Session::put('error','Payment failed');
            return view('payment.paypal',[
                'payment_count' => $payment_count
            ]);
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {         
            Session::put('success','Payment success !!');
            view('payment.paypal',[
                'payment_count' => $payment_count
            ]);;
        }

        \Session::put('error','Payment failed !!');



	    return	view('payment.paypal',[
            'payment_count' => $payment_count
        ]);
    }

    
}
