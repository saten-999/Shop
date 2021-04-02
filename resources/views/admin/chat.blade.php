@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"></div>
                    <chat-admin :user="{{ auth()->user() }}"></chat-admin>
            </div>
        </div>
    </div>
</div>
@endsection