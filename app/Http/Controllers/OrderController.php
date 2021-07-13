<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order;
use Auth;
Use Session;
Use \App\Item;

class OrderController extends Controller
{
	public function checkout(){
		//1) save the transaction in our orders table

		// if user is logged in create order details
		if(Auth::user()){
			$total = 0;
			$order = new Order;
			$order->status_id = 1; //assigns "pending" status
			$order->payment_id = 1; //assigns "COD" status
			$order->user_id = Auth::user()->id; // retrieves user id from the logged in user
			$order->total = 0;
			$order->save();

			foreach(Session::get('cart') as $id => $quantity){
				$order->items()->attach($id, ["quantity" => $quantity]);
				$item = Item::find($id);
				$total += $item->price*$quantity;
			}

			$order->total += $total;
			$order->save();

			Session::forget('cart');
			return redirect('/catalog');
		} else {
			return redirect('/login');
		}
	}

	public function indivorder(){
		$orders =  Order::where('user_id', Auth::user()->id)->get();

		return view('orders', compact('orders'));
	}

	public function index(){
		$orders =  Order::all();

		return view('allorders', compact('orders'));
	}

	public function cancelorder($id){
		$order = Order::find($id);
		$order->status_id = 3;
		$order->save();

		return redirect('/admin/allorders');
	}
	
	public function markaspaid($id){
		$order = Order::find($id);
		$order->status_id = 2;
		$order->save();

		return redirect('/admin/allorders');
	}
}