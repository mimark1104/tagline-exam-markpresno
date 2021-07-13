<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::all();
        return view('catalog', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('additemform', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = array(
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "img_path" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        );

        $this->validate($request, $rules);

        $new_item = new Item;
        $new_item->name = $request->name;
        $new_item->description = $request->description;
        $new_item->price = $request->price;
        $new_item->category_id = $request->category_id;

        //image handling
        //get image from files
        $image = $request->file("img_path");
        $image_name = time().".".$image->getClientOriginalExtension();

        //time() gets the current time
        //getClientOriginatExtension gets file extension
        $destination = "images/"; //corresponds to /public/images

        $image->move($destination, $image_name);

        $new_item->img_path = $destination.$image_name;
        $new_item->save();

        Session::flash("message", "$new_item->name has been added");
        return redirect('/catalog');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item=Item::find($id);
        $categories = Category::all();

        return view('edititemform', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        $rules = array(
            "name" => "required",
            "description" => "required",
            "price" => "required|numeric",
            "category_id" => "required",
            "image_path" => "image|mimes:jpeg,png,gif,jpg,svg"
        );
        
        $this->validate($request, $rules);

        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->category_id = $request->category_id;

        if($request->file('img_path')!=null){
            $image = $request->file('img_path');
            $image_name = time().".".$image->getClientOriginalExtension();
            $destination = "images/";
            $image->move($destination,$image_name);
            $item->img_path = $destination.$image_name;
        }
        $item->save();
        Session::flash("message", "$item->name has been updated");
        return redirect('/catalog');
        
    }

       

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item=Item::find($id);
        $item->delete();

        Session::flash("message", "$item->name has been deleted");
        return redirect('/catalog');
    }

    public function addtocart($id, Request $request){
        //1) to check whether we already have an existing cart in session
            // 1A) if cart is already exisiting get the values
            // 1B) else if no cart is defined, create an array cart
        if(Session::has('cart')){
            $cart = Session::get('cart');
        } else {
            $cart =[];
        }

        //2) check if the item in our cart has a quantity already. if yes, add to it, if no, assign.

        if(isset($cart[$id])){
            $cart[$id] += $request->quantity;
        } else {
            $cart[$id] = $request->quantity;
        }

        //dd($cart);
        Session::put("cart", $cart);

        $item = Item::find($id);
        Session::flash("message", "$request->quantity of $item->name successfully added to cart");
        //return redirect("/catalog");
        return array_sum($cart);
    }

    public function showcart(){
    //1) We want to create an array of items containing item name, price, quantity and subtotal

        //1A) initialize item array
        $item_cart = [];
        $total = 0;
        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart as $id=>$quantity){
                $item = Item::find($id);
                $item->quantity = $quantity;
                $item->subtotal = $item->price * $quantity;
                $item_cart[] = $item;
                $total += $item->subtotal;
            }

        }

        return view('cart', compact("item_cart", "total"));
    }

    public function changeqty($id){
        Session::forget("cart.$id");
        return redirect('/cart');
    }

    public function emptycart(){
        Session::forget('cart');
        return redirect('/cart');
    }

    public function updateqty(Request $request){
        //1) we need the cart
        $cart = Session::get('cart');
        $cart[$request->id] = $request->quantity;
        Session::put("cart", $cart);
        return redirect('/cart');
    }
}
