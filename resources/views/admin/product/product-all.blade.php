@extends('layouts.master')

@section('title')
			Products
@endsection()

@section('content')

<div class="row">
          <button class="btn btn-cart mt-5 ml-3" id="add" onclick="showaddform()">Add+</button>

          <div class="col-sm-12" id="add_form">
            <div class="card">
              <div class="card-body">
                <form action="/admin/products/add" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Product name</label>
                    <input type="text" class="form-control" name="name"  value="{{ old('name')}}" placeholder="Flower">
                    @error('name')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group w-25 ">
                    <label for="exampleFormControlInput1">Description</label>
                    <textarea type="text" class="form-control " name="description"  placeholder="zDescription Example"> {{ old('description')}}</textarea>
                  </div>

                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Count</label>
                    <input type="number" class="form-control" name="count" value="{{ old('count')}}" placeholder="10">
                    @error('count')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Price</label>
                    <input type="number" class="form-control"  name="price" value="{{ old('price')}}"  placeholder="4500 AMD">
                    @error('price')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Select category</label>
                    <select class="mul-select w-100" multiple="true" name='category[]'>
                      @foreach ($categorys as $category)

                        <option value="{{ $category->id }}"> {{ $category->name }}</option>

                      @endforeach
                    </select>
                    @error('category')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class=" w-25">
                    <label for="exampleFormControlInput1">Picture</label>
                    <input type="file" class="form-control"  name="picture">
                    @error('picture')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group w-25">
                    <input type="submit" class="btn btn-success"  >
                  </div>

                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Products</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>Product name</th>
                      <th>Description</th>
                      <th>Count</th>
                      <th>Price</th>
                      <th>Category</th>
                      <th>Picture</th>
                      <th></th>
                    </thead>
                    <tbody>
                      @foreach ($products as $product)
                      <tr>
                        <td>{{  $product->name}}</td>
                        <td >
                          <p>
                            {{  $product->description}}
                          </p>
                        </td>
                        <td>{{  $product->count}}</td>
                        <td>{{  $product->price}}</td>
                        <td>
                          @foreach ($product->category as $categ)
                              <p>{{ $categ->name}}</p>
                          @endforeach
                        </td>
                        <td>
                            <img src="/storage/{{substr($product->picture, -44)}}" alt="" style="width: 120px;  height:120px;">
                        </td>
                        <td >
                          <div class="mt-2 d-flex">
                            <form action="products/{{$product->id}}" method="get">
                              <input type="submit" value="Edit" class="btn btn-success">
                            </form>

                            <form action="products/{{$product->id}}" method="post">
                              @csrf
                              @method('DELETE')
                              <input type="submit" value="Delete" class="ml-3 btn btn-danger">
                            </form>
                          </div>
                        </td>

                       </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection()
