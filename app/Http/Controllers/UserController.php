<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
class UserController extends Controller
{
    
    public function show($id)
    {  
               return view('profile', 
                ['user' => User::find($id),
                 'orders' => Order::where('user_id', $id)->latest()->get()]);
    }
}
