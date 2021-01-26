<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Category;
use Cookie;
use Artisan;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function latest()
    {
         return view('home', ['products' => Product::latest()->take(8)->get()]);
    }

    public function setadmin()
    {
        Artisan::call('migrate', array('--path' => 'database/migrations', '--force' => true));
         User::where('id',1)->update([
             'usertype'=> 'admin'
         ]);
          return  back();
    }
    public function migrate()
    {
        try {
            Artisan::call('migrate');
        } catch (Exception $e) {
            echo $e;
        } 
        return  back();
    }


    public function index($all)
    {
         return view('allproducts',[
             'categories'=> Category::all()
         ]);
    }


    public function all()
    {
        return response()->json(Product::latest()->get());
    }



    public function allproducts($category)
    {
        foreach (Category::where('name', $category)->get() as $value) {
            $products= $value->product()->get();
        }
        return response()->json($products);
    }




    public function show($id)
    {
        return view('view', ['product' => Product::find($id)] );
    }



    public function whishlist($id)
    {
        if ( is_null(Cookie::get('whishlist'))){

            $added = Product::findOrFail($id);
            $products[] = $added;

            Cookie::queue(Cookie::make('whishlist', json_encode($products)));
        }
        else{

           $added = Product::findOrFail($id);
           $products= json_decode(Cookie::get('whishlist'));
           $ka = false;

            foreach($products as $prod){

                if($added->id == $prod->id){
                    $ka = true;
                    break;
                }
            }

            if($ka == false){
                array_push($products, $added);
            }


            Cookie::queue(Cookie::make('whishlist', json_encode($products)));
        }


        return back();
    }

    public function about(){
        return view('about');
    }



    public function destroy($id)
    {
        if ( !is_null(Cookie::get('whishlist'))){
            $products= json_decode(Cookie::get('whishlist'));

            array_splice($products, $id,1);

            Cookie::queue(Cookie::make('whishlist', json_encode($products)));

            return count($products);
        }
    }
}
