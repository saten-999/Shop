<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Order;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\DB;
class AdminTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function only_admin_user_can_see_this_page(){

        $user = factory(User::class)->create(['usertype' => 'admin']);

        $responce = $this->actingAs($user)->get('/use/admin');

        $responce->assertSuccessful(200);
    }

    /** @test */
    public function only_admin_can_use_this_page(){

        $user = factory(User::class)->create();

        $responce = $this->actingAs($user)->get('/use/admin');

        $responce->assertRedirect('/home');
    }


    /** @test */
    public function show_product(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        


        $responce = $this->actingAs($user)->get('/admin/products');


        $responce->assertViewIs('admin.product.product-all');

        $responce->assertViewHasAll(['products', 'categorys']);

        $responce->assertSuccessful();

    }
    /** @test */
    public function create_products(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $category = factory(Category::class)->create();
        $category1 = factory(Category::class)->create();
 

        Storage::fake('public');

        $file = UploadedFile::fake()->image('sss.jpg');

        $responce = $this->actingAs($user)->post('/admin/products/add',[
            'name' => 'flow',
            'description' => 'testing prod',
            'count' => 5,
            'price' => 15000,
            'picture' =>  $file ,
            'category' => array( $category->id, $category1->id)

        ]);

        
        Storage::disk('public')->assertExists('product/' . $file->name);

        
        $this->assertDatabaseHas('products',[
            'name' => 'flow',
            'description' => 'testing prod',
            'count' => 5,
            'price' => 15000,
            'picture' => 'product/' . $file->name
            
        ]);

        $this->assertDatabaseHas('product_category',[
            'product_id' => Product::latest()->first()->id,
            'category_id' => $category->id,
           
            
        ]);
        $responce->assertStatus(302);
    }

 /** @test */
    public function edit_product(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $product = factory(Product::class)->create();


        $responce = $this->actingAs($user)->get('admin/products/'.$product->id);


        $responce->assertViewIs('admin.product.product-edit');

        $responce->assertViewHasAll(['product']);

        $responce->assertSuccessful();

    }
    /** @test */
    public function update_products(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $product = factory(Product::class)->create();
        $category = factory(Category::class)->create();
        $category1 = factory(Category::class)->create();
 


        Storage::fake('public');

        $file = UploadedFile::fake()->image('sss.jpg');

        $responce = $this->actingAs($user)->put('/admin/products/'.$product->id,[
            'name' => 'update test',
            'description' => 'testing prod',
            'count' => 5,
            'price' => 15000,
            'picture' =>  $file ,
            'category' => array( $category->id, $category1->id)
        ]);

        
        Storage::disk('public')->assertExists('product/' . $file->name);

        
        $this->assertDatabaseHas('products',[
            'name' => 'update test',
            'id' => $product->id,
            'description' => 'testing prod',
            'count' => 5,
            'price' => 15000,
            // 'picture' =>  $file ,
        ]);

        $this->assertDatabaseHas('product_category',[

            'product_id' => $product->id,
            'category_id' => $category->id,
            
        ]);
        $responce->assertStatus(302);
    }



    /** @test */
    public function delete_products(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $product = factory(Product::class)->create();


        $responce = $this->actingAs($user)->delete('/admin/products/'.$product->id);

        
        $this->assertDeleted('products', [
            'name' => $product->name,
            'description' => $product->description,
            'count' => $product->count,
            'price' => $product->price,
            // 'picture' =>   $product->picture,
           
        ]);
    }

    /** @test */
    public function show_category(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);

        $responce = $this->actingAs($user)->get('/admin/category');

        $responce->assertViewHas('categorys');

        $responce->assertViewIs('admin.category.category');

    }

    /** @test */
    public function create_category(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);

        $responce = $this->actingAs($user)->post('/admin/category',[
            'name' => 'test category'
        ]);

        $this->assertDatabaseHas('categories',[
            'name' => 'test category'
        ]);

    }

    /** @test */
    public function edit_category(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $category = factory(Category::class)->create();

        $responce = $this->actingAs($user)->get('admin/category/'.$category->id);

        $responce->assertViewHas('category');

        $responce->assertViewIs('admin.category.edit');

    }

    /** @test */
    public function update_category(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $category = factory(Category::class)->create();

        $responce = $this->actingAs($user)->put('/admin/category/'.$category->id,[
            'name' => 'test updated category'
        ]);

        $this->assertDatabaseHas('categories',[
            'name' => 'test updated category'
        ]);

    }


    /** @test */
    public function delete_category(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $category = factory(Category::class)->create();

        $responce = $this->actingAs($user)->delete('/admin/category/'.$category->id);

        $this->assertDeleted('categories',[
            'name' => $category->name
        ]);

    }


    /** @test */
    public function role_update(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $user1 = factory(User::class)->create(['usertype' => 'admin']);
        

     

        $responce = $this->actingAs($user)->put('role-register-update/'.$user1->id,[
            'username' => 'testing update role',
            'usertype' => null,

        ]);

        

        
        $this->assertDatabaseHas('users',[
            'name' => 'testing update role',
            'usertype' => null
            
        ]);

        $responce->assertStatus(302);
    }


    /** @test */
    public function role_delete(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $user1 = factory(User::class)->create(['usertype' => 'admin']);
        


        $responce = $this->actingAs($user)->delete('role-delete/'.$user1->id);

        

        
        $this->assertDeleted('users',[
            'id' => $user1->id,
            'name' => $user1->name,
            
        ]);

        $responce->assertStatus(302);
    }

     /** @test */
     public function role_edit(){

        $this->withExceptionHandling();
        
        $user = factory(User::class)->create(['usertype' => 'admin']);
        $user1 = factory(User::class)->create(['usertype' => 'admin']);
        

        
        $responce = $this->actingAs($user)->get("/role-edit/$user1->id");
        $users = User::find($user1->id);
        $responce->assertViewHas('users', $users);

        $responce = $this->actingAs($user)->get("/admin/role-register");
        $users = User::latest()->get();
        $responce->assertViewHas('users', $users);


        $responce = $this->actingAs($user)->get("/use/admin");
        $responce->assertViewHas('users', $users);
    }


    /** @test */
    public function orders(){

        $this->withExceptionHandling();
        
        $admin = factory(User::class)->create(['usertype' => 'admin']);
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $order = factory(Order::class)->create(['user_id' => $user->id ]);
        

        DB::table('order_product')->insert([
            'order_id'=> $order->id,
            'product_id' => $product->id, 
            'count'=> 1,
           ]);

        $responce = $this->actingAs($admin)->get("/admin/order");
        $responce->assertViewIs('admin.order.order-all');


        $responce = $this->actingAs($admin)->delete("/admin/order/$order->id");
        $responce->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'done',
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'count' => $product->count-1,
        ]);
    }
}
