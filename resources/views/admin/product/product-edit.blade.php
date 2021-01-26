@extends('layouts.master')

@section('title')
			Edit Product
@endsection()

@section('content')

<div class="row">


          <div class="col-sm-12" >
            <div class="card">
              <div class="card-body">
                <form action="/admin/products/{{$product->id}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Product name</label>
                  <input type="text" class="form-control" name="name"  value="{{ $product->name }}" placeholder="Flower">
                  </div>

                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Description</label>
                    <textarea type="text" class="form-control" name="description" placeholder="zdfnbdzfnzfgnxnfgm"> {{ $product->description }}</textarea>
                  </div>

                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Count</label>
                    <input type="number" class="form-control" name="count" value="{{ $product->count }}" placeholder="10">
                  </div>

                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Price</label>
                    <input type="number" class="form-control"  name="price" value="{{ $product->price}}"  placeholder="4500 AMD">
                  </div>
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Select category</label>
                    <select class="mul-select w-100 h-100" multiple="true" name='category[]'>

                      @foreach ($product->category as $selected_category)

                        <option value="{{ $selected_category->id }}"  selected> {{ $selected_category->name }}</option>

                          @foreach ($categorys as $category)
                              @if ($category->id != $selected_category->id   )
                                <option value="{{ $category->id }}"  > {{ $category->name }}</option>
                              @endif
                          @endforeach
                      @endforeach
                    </select>
                  </div>
                  <div class=" w-25">
                    <label for="exampleFormControlInput1">Picture</label>
                    <input type="file" class="form-control"   name="picture">
                  </div>

                  <div class="form-group w-25">
                    <input type="submit" class="btn btn-success"  >
                  </div>

                </form>
              </div>
            </div>
          </div>

        </div>

@endsection()

