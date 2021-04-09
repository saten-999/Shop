<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


    public function index()
    {
    	return view('admin.dashboard',[
            'users' => User::latest()->get()
        ]);

    }
    public function registered()
    {

    	$users = User::latest()->get();

    	return view('admin.register')->with('users',$users);

    }
    // here we create fuction for edit users
    public function registeredit(Request $request, $id)
    {
    	$users = User::findOrFail($id);
        
    	return view('admin.register-edit')->with('users',$users);
    }

    // here we create function for update button
    public function registerupdate(Request $request, $id)
    {
    	$users = User::find($id);
    	$users->name = $request->input('username');
    	$users->usertype = $request->input('usertype');
    	$users->update();

    	return redirect('/admin/role-register')->with('status','data is updated'); 
    }
    
    //delete function
    public function registerdelete($id)
    {
        User::findOrFail($id)->delete();
        
        return redirect('/admin /role-register')->with('status','data deleted');

    }
}
