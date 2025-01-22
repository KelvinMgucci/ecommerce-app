<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{
    public function index(){
        $user = User::where('usertype','user')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        $delivered = Order::where('status','Delivered')->get()->count();
        return view('admin.index',compact('user','product','order','delivered'));
    }

public function home(){
    $product = Product::all();

    if(Auth::id()){
    $user = Auth::user();
    $userid = $user->id;
    $count = Cart::where('user_id',$userid)->count();
    }
    else{
        $count='';
    }

    return view('home.index',compact('product','count'));
}

public function login_home(){
    $product = Product::all();
    if(Auth::id()){
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id',$userid)->count();
        }
        else{
            $count='';
        }
    
    return view('home.index',compact('product','count'));

}

public function product_details($id){

    $data = Product::find($id);
    if(Auth::id()){
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id',$userid)->count();
        }
        else{
            $count='';
        }
    
    return view('home.product_details',compact('data','count'));
}

public function add_cart($id)
{
    $product_id = $id;
    $user = Auth::user();
    $user_id = $user->id;
    $data = new Cart;
    $data->user_id = $user_id;
    $data->product_id = $product_id;
    $data->save();
    
    // Flash success message to the session
    session()->flash('success', 'Product Added To Cart successfully');

    return redirect()->back();
}


public function mycart(){

    if(Auth::id()){
        $user = Auth::user();
        $userid = $user->id;
        $count = Cart::where('user_id',$userid)->count();
        $cart = Cart::where('user_id',$userid)->get();
        }
        else{
            $count='';
        }
    return view('home.mycart',compact('count','cart'));
}

public function delete_cart($id)
{
    $data = Cart::find($id);
    $data->delete();

    // Flash success message to the session
    session()->flash('success', 'Item Removed to cart');

    return redirect()->back();
}


public function confirm_order(Request $request){

$name = $request->name;
$address = $request->address;
$phone = $request->phone;

$userid = Auth::user()->id;
$cart = Cart::where('user_id',$userid)->get();

foreach($cart as $carts){
    $order = new Order;
    $order->name = $name;
    $order->rec_address = $address;
    $order->phone = $phone;
    $order->user_id = $userid;
    $order->product_id = $carts->product_id;
    $order->save();
   
}
$cart_remove = Cart::where('user_id',$userid)->get();
foreach($cart_remove as $remove){
$data = Cart::find($remove->id);
$data->delete();
}

session()->flash('toastr_success', 'Order Succesfully Placed');

return redirect()->back();


}

public function myorders()
{
    // Get the currently authenticated user's ID
    $user = Auth::user()->id;

    // Get the count of items in the user's cart (optional for the page)
    $count = Cart::where('user_id', $user)->count();

    // Get all orders associated with the user
    $orders = Order::where('user_id', $user)->get();

    // Return the view with the order data and cart count
    return view('home.order', compact('count', 'orders'));
}
}

