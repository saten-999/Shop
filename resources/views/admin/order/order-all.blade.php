@extends('layouts.master')

@section('title')
		Orders
@endsection()

@section('content')

<div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Orders</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>Product name</th>
                      <th>Price</th>
                      <th>Picture</th>
                      <th>Order Count</th>
                      <th>Product Count</th>
                    </thead>
                    <tbody>
                      @foreach ($orders as $order)
                        
                        <tr>
                          @foreach ($order->product as $item)
                          <td >
                            <p>
                              {{  $item->name}}  
                            </p>
                          </td>
                          <td>{{  $item->price}}</td>
                          {{-- <td>{{  $product->price}}</td> --}}
                          {{-- <td>
                            @foreach ($product->category as $categ)
                                <p>{{ $categ->name}}</p>
                            @endforeach
                          </td> --}}
                          <td> 
                              <img src="/storage/{{$item->picture}}" alt="" style="width: 120px;  height:120px;">
                          </td>
                          <td> 
                            {{$item->pivot->count}}
                          </td>
                          <td>{{$item->count}}</td>
                          {{-- <td >
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
                          </td> --}}
                          
                         </tr>
                        @endforeach 
                      
                        
                        <tr>
                          <td> <div class="h6 text-danger">{{$order->phone}}</div> </td>
                          <td> <div class="h6 text-danger">{{$order->delivery}}</div> </td>
                          <td> <div class="h6 text-danger">{{$order->date}}</div> </td>
                          <td> <div class="h6 text-danger">{{$order->address}}</div> </td>
                          <td> <div class="h6 text-danger">
                            <form action="/admin/order/{{$order->id}}" method="post">
                              @csrf
                              @method('DELETE')
                              <input type="submit" value="Done" class="ml-3 btn btn-success">
                            </form></div> </td>
                         
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