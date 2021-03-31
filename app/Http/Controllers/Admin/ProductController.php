<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.product-all', ['products' => Product::latest()->get(),
                                                  'categorys' => Category::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->validate([
          'name' => 'required',
          'description' => 'required',
          'count' => 'required',
          'price' => 'required',
          'picture' => 'file',
          'category' => 'required',
      ]);

      $data['picture'] = $request->file('picture')->storeAs(
        'product', $request->file('picture')->getClientOriginalName() , 'public'
            );
    
       $product =Product::create($data);
       $product->category()->attach($data['category']);

       return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit( $product)
    {
        return view('admin.product.product-edit', ['product' => Product::find($product),
                                                        'categorys' => Category::latest()->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'count' => 'required',
            'price' => 'required',
            'picture' => 'file',
            'category' => 'required',
        ]);

        $data['picture'] = $request->file('picture')->storeAs(
          'product', $request->file('picture')->getClientOriginalName() , 'public'
              );

         $product = Product::find($id);
         $product->update($data);

         $product->category()->sync( $data['category']);

         return redirect('admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return back();
    }
}
