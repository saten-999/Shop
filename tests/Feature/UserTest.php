<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\Category;
use App\User;
class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function whishlist(){

        $this->withExceptionHandling();
        
        $product = factory(Product::class)->create();
        


        $responce = $this->get('product/wishlist/'.$product->id);

        $res = $this->get('/prod/whishlist');

        $res->assertCookie('whishlist');
        $responce->assertCookie('whishlist');


    }

    /** @test */
    public function cart(){

        $this->withExceptionHandling();
        
        $product = factory(Product::class)->create();
        
        $this->assertGuest();

        $responce = $this->get('cart/'.$product->id);

        $res = $this->get('/cart');
        $res->assertCookie('cart_products' );
        $responce->assertCookie('cart_products');


    }

    /** @test */
    public function delete_cart_product(){

        $this->withExceptionHandling();
        
        $product = factory(Product::class)->create();
        
        $this->assertGuest();

        $responce = $this->get('cart/'.$product->id);
        $responce->assertCookie('cart_products');


        $responce->assertStatus(200);

    }

    /** @test */
    public function order_products(){

        // $this->withExceptionHandling();
        
        // $product = factory(Product::class)->create();
        $this->withExceptionHandling();
        
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $res = $this->get('cart/'.$product->id);


        $responce = $this->actingAs($user)->post('cart/order');

        $responce->assertCookie('cart_products');


        $responce->assertStatus(302);
     

        

    }

     /** @test */
     public function view_product(){

        
        $this->withExceptionHandling();
        
        $product = factory(Product::class)->create();

        $responce = $this->get('/product/view/'.$product->id);

        $responce->assertViewHas('product');

        $responce->assertStatus(200);
     

        

    }

    /** @test */
    public function all_products(){

        
        $this->withExceptionHandling();
        
        $responce = $this->get('/all/all');

        $responce->assertJson(Product::latest()->get()->toArray());  

        $category = factory(Category::class)->create();
        $product =  factory(Product::class)->create();
        $product->category()->attach([$category->id]);

        $responce = $this->get("/all/$category->name");

        $responce->assertJson([Product::find($product->id)->toArray()]);

        
    }

    /** @test */
    public function home(){

        $this->withExceptionHandling();
            
        $response = $this->get('/home');
    
        $prod = Product::latest()->take(8)->get();
        $response->assertViewHas('products',$prod);
            
    
            
    }

    
}
