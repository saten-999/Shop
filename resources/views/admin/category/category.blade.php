@extends('layouts.master')

@section('title')
			Categories
@endsection()

@section('content')

<div class="row">
          <button class="btn btn-cart mt-5 ml-3" id="add" onclick="showaddform()">Add Category</button>
          
          <div class="col-sm-12" id="add_form">
            <div class="card">
              <div class="card-body">
                <form action="/admin/category" method="POST" enctype="multipart/form-data"> 
                  @csrf
                  <div class="form-group w-25">
                    <label for="exampleFormControlInput1">Category name</label>
                    <input type="text" class="form-control" name="name"  value="{{ old('name')}}" placeholder="Category name">
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Categoris</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>Category name </th>
                      <th> </th>
                   
                      <th></th>
                    </thead>
                    <tbody>
                      @foreach ($categorys as $category)
                      <tr>
                        <td>{{  $category->name}}</td>
                        <td >
                          <div class="mt-2 d-flex">
                            <form action="category/{{$category->id}}" method="get">
                              <input type="submit" value="Edit" class="btn btn-success">
                            </form>

                            <form action="category/{{$category->id}}" method="post">
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

@section('scripts')


@endsection()