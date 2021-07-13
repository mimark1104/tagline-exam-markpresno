<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use \App\User;
Use \App\Role;

class UserController extends Controller
{
    public function index(){
    	$users = User::all();
    	$roles = Role::all();

    	return view('users', compact('users','roles'));
    }

    public function updaterole($id, Request $request){
    	$user = User::find($id);
    	$user->role_id = $request->role_id;
    	$user->save();

    	return redirect('/users');
    }
}
