<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /** 
     * function to get all product
     * no parameters
     * @return response
    */
    public function products () {
        $products = Product::get();
        return response()->json($products);
    }

    /** 
     * function to get specific product
     * recieve parameters
     * $id to get the product
     * @return response
    */
    public function product ($id) {
        $product = Product::get();
        if (isset($product)) {
            return response()->json($product);
        }
        return response()->json('This product is not exist in database');
    }

    /** 
     * function to store new product
     * recieve parameters
     * $request to get the data
     * @return response
    */
    public function saveProduct(Request $request) {
        $this->validate($request,['product_name' => 'required', 'product_price' => 'required', 'product_image' => 'image|nullable|max:1999']);
        if($request->input('product_category')) {
            $pro_name = $request->product_name;
            $pro_price = $request->product_price;
            $pro_category = $request->product_category;
            $pro_image = $request->product_image;
            $product = new Product();
            if($request->hasFile('product_image')) {
                $image_name = time().'_'.$request->product_image->getClientOriginalName();
                $filePath = $request->file('product_image')->move('product_images', $image_name);
                $product->product_image = time().'_'.$request->product_image->getClientOriginalName();
            } else {
                $image_name = 'noimage.jpg';
            }
            if($request->has('sale')) {
                $product->sale = 1;
                $product->percent = $request->percent;
                $product->sale_price = $request->sale_price;
            } else {
                $product->sale = 0;
                $product->percent = 0;
                $product->sale_price = 0;
            }
            $product->product_name = $pro_name;
            $product->product_price = $pro_price;
            $product->product_category = $pro_category;
            $product->product_image = $image_name;
            $product->status = 0;
            $product->save();
            return response()->json($product);
        } else {         
            return response()->json('Please, select the category');;
        }
    }

    /** 
     * function to update new product
     * recieve parameters
     * $request to get the data
     * @return response
    */
    public function updateProduct(Request $request, $id) {
        $this->validate($request,['product_name' => 'required', 'product_price' => 'required', 'product_image' => 'image|nullable|max:1999']);
        $product = Product::find($id);
        if (isset($product)) {
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_category = $request->product_category;
            $product->status = 0;
            if ($request->hasFile('product_image')) {
                $image_name = time().'_'.$request->product_image->getClientOriginalName();
                $filePath = $request->file('product_image')->move('product_images', $image_name);
                $product->product_image = time().'_'.$request->product_image->getClientOriginalName();
            } else {
                $old_image = $product->product_image;
                $product->product_image = $old_image;
            }
            if ($request->has('sale')) {
                $product->sale = 1;
                $product->percent = $request->percent;
                $product->sale_price = $request->sale_price;
            } else {
                $product->sale = 0;
                $product->percent = 0;
                $product->sale_price = 0;
            }
            $product->save();
            $msg = 'Updated successfully';
            $data = [
                'prduct' => $product,
                'msg'    => $msg
            ];
            return response()->json($data);
        }
        return response()->json('This product is not exist in database');
    }

    /** 
     * function to activate product
     * recieve parameters
     * $request to get the data
     * @return response
    */
    public function activateProduct($id)
    {
        $product = Product::find($id);
        if(isset($product)) {
            if($product->status == 0) {
                $product->status = 1;
                $product->save();
                $msg = 'Product has been activated successfuy';
                $data = [
                    'Product' => $product,
                    'msg'     => $msg
                ];
                return response()->json($data);
            } else {
                return response()->json('Product is already activated');
            }
        } else {
            return response()->json('This product is not exist in database');
        }
    }

    /** 
     * function to deactivate product
     * recieve parameters
     * $request to get the data
     * @return response
    */
    public function deactivateProduct($id) {
        $product = Product::find($id);
        if(isset($product)) {
            if($product->status == 1) {
                $product->status = 0;
                $product->save();
                $msg = 'Product has been deactivated successfuy';
                $data = [
                    'Product' => $product,
                    'msg'     => $msg
                ];
                return response()->json($data);
            } else {
                return response()->json('Product is already deactivated');
            }
        } else {
            return response()->json('This product is not exist in database');
        }
    }

    /** 
     * function to delete product
     * recieve parameters
     * $request to get the data
     * @return response
    */
    public function deleteProduct($id) {
        $product = Product::find($id);
        if (isset($product)) {
            $product->delete();
            $msg = 'The product has been deleted successfully';
            $data = [
                'Product' => $product,
                'msg'     => $msg
            ];
            return response()->json($data);
        } else {
            return response()->json('This product is not exist in database');
        }
    }




}
