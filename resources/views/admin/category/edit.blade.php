@extends('layouts.master')

@section('title')
			Edit Category
@endsection()

@section('content')

<div class="row ">
          
          <div class="col-sm-12 " >
            <div class="card">
              <div class="card-body ">
              <form action="/admin/category/{{ $category->id}}" method="POST" enctype="multipart/form-data"> 
                  @csrf
                  @method('PUT')
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Category name</label>
                    <input type="text" class="form-control" name="name"  value="{{ $category->name}}" placeholder="Category name">
                    @error('name')
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
     
        </div>

@endsection()

@section('scripts')


@endsection()