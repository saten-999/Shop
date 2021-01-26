@extends('layouts.app')

@section('content')
    
    <div class="container">
        <div class="row mt-5">
            <div class="col-sm-3 text-center h5 font-weight-bold">
                {{ $user->name}}
            </div>
            <div class="col-sm-3 text-center h5 font-weight-bold">
                {{ $user->email}}
            </div>
            <div class="col-sm-6">
                
            </div>
        </div>
        
        <div class="row " style="margin-top: 100px;">
            <div class="col-sm-12 text-center h3 font-weight-bold">
                My Orders
            </div>
        </div>
        <div class="row mt-5 " style="margin-top: 50px;">
                
            <div class="col-sm-2 font-weight-bold text-center">Product Image </div>
            <div class="col-sm-2 font-weight-bold text-center">Name</div>
            <div class="col-sm-2 font-weight-bold text-center">Price</div>
            <div class="col-sm-2 font-weight-bold h6">Status</div>
            <div class="col-sm-2 font-weight-bold h6">Count</div>
            <div class="col-sm-2 font-weight-bold h6"></div>
        </div>
        @foreach ($orders as $order)
        
        
            {{-- <div class="row">
                <div class="col-sm-4 h6">{{$order->phone}}</div>
                <div class="col-sm-4 h6">{{$order->address}}</div>
                <div class="col-sm-4 h6">{{$order->status}}</div>
            </div> --}}
       
        @foreach ($order->product as $item)
        
            <div class="row mt-5">
                
                <div class="col-sm-2 text-center">
                    <img src="/storage/{{$item->picture}}" alt="" class="w-75">
                </div>
                <div class="col-sm-2 text-center">{{$item->name}}</div>
                <div class="col-sm-2 text-center">{{$item->price}}</div>
                <div class="col-sm-2 h6">{{$order->status}}</div>
                <div class="col-sm-2 h6">{{$item->pivot->count }}</div>
                <div class="col-sm-2 h6"></div>
            </div>
        
        @endforeach
        @endforeach
    </div>
@endsection