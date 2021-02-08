<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Category;
use App\Cart;

class ProductController extends Controller
{
    /*
    ** function display form, to add new product
    ** no parameters
    ** return view
    */
    public function addProduct()
    {
        $categories = Category::All()->pluck('category_name', 'category_name');
        return view('admin.addproduct', compact('categories'));
    }

    /*
    ** function to save the product data in database
    ** recieve parameter
    *** $request, to get the form data
    ** return success message redirected to add product page
    */
    public function saveProduct(Request $request)
    {
        $this->validate($request,['product_name' => 'required',
                                  'product_price' => 'required',
                                  'product_image' => 'image|nullable|max:1999']);
        
        if($request->input('product_category'))
        {
            // get the form inputs
            $pro_name = $request->product_name;
            $pro_price = $request->product_price;
            $pro_category = $request->product_category;
            $pro_image = $request->product_image;
            // $pro_status = $request->status;
            // create new prduct
            $product = new Product();
            /*
            ** check if there is image, store it
            ** if there no images, store noimage.jpg file
            */
            if($request->hasFile('product_image'))
            {
                // get file name and generate unique name
                $image_name = time().'_'.$request->product_image->getClientOriginalName();
                // upload images
                $filePath = $request->file('product_image')->move('product_images', $image_name);
                // store the image in database
                $product->product_image = time().'_'.$request->product_image->getClientOriginalName();
            }
            else
            {
                // if there is no image, put a default image
                $image_name = 'noimage.jpg';
            }
            // check if the product has sale or not
            if($request->has('sale'))
            {
                $product->sale = 1;
                $product->percent = $request->percent;
                $product->sale_price = $request->sale_price;
            }
            else
            {
                $product->sale = 0;
                $product->percent = 0;
                $product->sale_price = 0;
            }
            // store the inputs data in the database
            $product->product_name = $pro_name;
            $product->product_price = $pro_price;
            $product->product_category = $pro_category;
            $product->product_image = $image_name;
            $product->status = 0;
            // save the product
            $product->save();
            // return seccess message
            return redirect('/addproduct')->with('status_p_a', 'The '.$pro_name.' product has been added successfully');
        }
        else
        {         
            return redirect('/addproduct')->with('status_p_n', 'Please, select the category !');
        }
    }
    
    /*
    ** function to show all products
    ** no parameters
    ** return view with inserted products
    */
    public function products()
    {
        $products = Product::get();
        return view('admin.products', compact(['products']));
    }

    /*
    ** function to display edit form
    ** recieve parameters
    *** $id -> to return product data
    ** return view with product and categories
    */
    public function editProduct($id)
    {
        $product = Product::find($id);
        $categories = Category::All()->pluck('category_name', 'category_name');
        return view('admin.editproduct', compact(['product', 'categories']));
    }

    /*
    ** function to store updated data
    ** recieve parameters
    *** $request to get the form data 
    *** $id to select the product
    ** return view
    */
    public function updateProduct(Request $request, $id)
    {
        $this->validate($request,['product_name' => 'required',
                                  'product_price' => 'required',
                                  'product_image' => 'image|nullable|max:1999']);
        // get the product stored data
        $product = Product::find($id);
        // store the inputs data in the database
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_category = $request->product_category;
        $product->status = 0;
        // check if there is photo
        if($request->hasFile('product_image'))
        {
            // get file name and generate unique name
            $image_name = time().'_'.$request->product_image->getClientOriginalName();
            // upload images
            $filePath = $request->file('product_image')->move('product_images', $image_name);
            // store the image in database
            $product->product_image = time().'_'.$request->product_image->getClientOriginalName();
        }
        else
        {
            // get the old image
            $old_image = $product->product_image;
            $product->product_image = $old_image;
        }
        // check if the product has sale or not
        if($request->has('sale'))
        {
            $product->sale = 1;
            $product->percent = $request->percent;
            $product->sale_price = $request->sale_price;
        }
        else
        {
            $product->sale = 0;
            $product->percent = 0;
            $product->sale_price = 0;
        }
        // save the product
        $product->save();
        return redirect('/products')->with('product_u', 'The '.$product->product_name.' product has been updated successfully');
    }
    
    /*
    ** function to delete product
    ** recieve parameters
    *** $id to get the selected product
    ** return view with success message
    */
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (isset($product))
        {
            $pro_name = $product->product_name;
            $product->delete();
            return redirect('products')->with('product_d', 'The '.$pro_name.' has been deleted successfully');
        }
        else
        {
            return redirect('products')->with('product_nd', 'Unable to delete this product');
        }
    }

    /*
    ** function to activate products
    ** recieve parameters
    *** $id to get the product
    */
    public function activateProduct($id)
    {
        $product = Product::find($id);
        $pro_name = $product->product_name;
        if(isset($product))
        {
            if($product->status == 0)
            {
                $product->status = 1;
                $product->save();
                return redirect('/products')->with('product_a', 'The '.$pro_name.' has been activated successfully');
            }
            else
            {
                return redirect('/products')->with('product_na', 'The '.$pro_name.' is already activated');
            }
        }
        else
        {
            return redirect('/products')->with('product_na', 'Unable to activate '.$pro_name.' right now');
        }
    }

    /*
    ** function to deactivate products
    ** recieve parameters
    *** $id to get the product
    */
    public function deactivateProduct($id)
    {
        $product = Product::find($id);
        $pro_name = $product->product_name;
        if(isset($product))
        {
            if($product->status == 1)
            {
                $product->status = 0;
                $product->save();
                return redirect('/products')->with('product_da', 'The '.$pro_name.' has been deactivated successfully');
            }
            else
            {
                return redirect('/products')->with('product_nda', 'The '.$pro_name.' is already deactivated');
            }
        }
        else
        {
            return redirect('/products')->with('product_nda', 'Unable to deactivate '.$pro_name.' right now');
        }
    }

    /*
    ** function to add product to cart
    ** recieve parameters
    *** $id to get the product
    ** return
    */
    public function addToCart($id)
    {
        // get the product via id
        $product = Product::find($id);
        // check if we have a cart -> get it's data in session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // create an object from Caert class
        $cart = new Cart($oldCart);
        // pass parameters to checkSale() function
        $cart->checkSale($product, $product->sale);
        // pass parameters to the add() function
        $cart->add($product, $id);
        // put the cart data in the session
        Session::put('cart', $cart);
        // for test the come data
        // dd(Session::get('cart'));
        return redirect('/shop');
    }

}
