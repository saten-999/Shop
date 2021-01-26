@extends('layouts.master')

@section('title')
			Welcome to Digital CRM!
@endsection()

@section('content')

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Users Data</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>Name</th>
                      <th>Email</th>
                      <th>Registered</th>
                      <th>Usertype</th>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{ $user->name}}</td>
                          <td>{{ $user->email}}</td>
                          <td>{{ $user->created_at}}</td>
                          <td>{{ $user->usertype}}</td>
                          
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