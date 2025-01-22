<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
class AdminController extends Controller
{
    public function view_category(){
        $data = Category::all();
        return view('admin.category',compact('data'));
    }

    public function add_category(Request $request)
{
    $category = new Category;
    $category->category_name = $request->category;
    $category->save();

    // Toastr success notification
    toastr()->timeOut(6000)->closeButton()->addSuccess('Category added successfully');
    
    // Flash the success message to the session
    session()->flash('success', 'Category added successfully'); // Adding this line

    return redirect()->back();
}



public function delete_category($id)
{
    $data = Category::find($id);

    if (!$data) {
        // If category not found, return an error
        return redirect()->back()->with('error', 'Category not found');
    }

    $data->delete(); // Perform the deletion
    toastr()->timeOut(6000)->closeButton()->addSuccess('Category deleted successfully');

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Category deleted successfully');
}


    public function edit_category($id){
        $data = Category::find($id);
        return view('admin.edit_category',compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
    
        if (!$data) {
            return redirect()->route('view_category')->with('error', 'Category not found');
        }
    
        $data->category_name = $request->category;
        $data->save();
    
        // Set session message for test assertion
        session()->flash('success', 'Category Updated successfully');
    
        toastr()->timeOut(6000)->closeButton()->addSuccess('Category Updated successfully');
        
        return redirect()->route('view_category');
    }
    

    public function add_product(){

        $category = Category::all();
    
        return view('admin.add_product',compact('category'));
    }

    public function upload_product(Request $request)
    {
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;
        $image = $request->image;
    
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }
    
        $data->save();
    
        // Use session flash message for easier testing
        session()->flash('success', 'Product Added successfully');
    
        return redirect()->back();
    }
    
    
    


    public function view_product(){
        $product=Product::paginate(5);

        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id)
    {
        // Find the product by ID
        $data = Product::find($id);
    
        // If the product exists, proceed with deletion
        if ($data) {
            // Delete the associated image file if it exists
            $image_path = public_path('products/'.$data->image);
            if (file_exists($image_path)) {
                unlink($image_path);  // Delete the image
            }
    
            // Delete the product record from the database
            $data->delete();
    
            // Add success message using Toastr
            session()->flash('success', 'Product Deleted successfully');
        }
    
        // Redirect back to the previous page
        return redirect()->back();
    }
    

    public function update_product($id){
        $data = Product::find($id);
        $category = Category::all();

        return view('admin.update_page',compact('data','category'));

    }

    public function edit_product(Request $request,$id){

        $data = Product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $image=$request->image;
        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
            $data->image=$imagename;
        }
        $data->save();
        session()->flash('success', 'Product Updated successfully');
        return redirect('/view_product');

    }

    public function product_search(Request $request){

        $search = $request->search;
        $product = Product::where('title','LIKE','%'.$search.'%')->
        orWhere('category','LIKE','%'.$search.'%')->paginate(3);
        return view('admin.view_product', compact('product'));
    }

    public function view_order(){
        $data = Order::all();


        return view('admin.view_order',compact('data'));
    }

    public function on_the_way($id){

        $data = Order::find($id);
        $data->status ='On The Way';
        $data->save();
        return redirect('/view_order');


    }

    public function delivered($id){
        $data = Order::find($id);
        $data->status ='Delivered';
        $data->save();
        return redirect('/view_order');
    }



}
