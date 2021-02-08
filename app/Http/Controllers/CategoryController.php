<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /*
    ** function to update category
    ** no parameters
    ** retrun view
    */
    public function addCategory()
    {
        return view('admin.addcategory');
    }

    /*
    ** function to save category
    ** recieve parameters
    *** $request to get form data
    *** $id to get category
    ** retrun add category page with session
    */
    public function saveCategory(Request $request)
    {
        $this->validate($request,['category_name' => 'required']);
        $getCat = $request->category_name;
        $checkCat = Category::where('category_name', $getCat)->first();
        $category = new Category;
        if(!$checkCat)
        {
            $category->category_name = $getCat;
            $category->save();
            return redirect('/addcategory')->with('status', 'The '.$getCat.' Category has been saved successfully');
        }
        else
        {
            return redirect('/addcategory')->with('status1', 'The '.$getCat.' Category is already exist');
        }
    }

    /*
    ** function to show categories page
    ** no parameters
    ** retrun view
    */
    public function categories()
    {
        $categories = Category::get();
        return view('admin.categories', compact('categories'));
    }

    /*
    ** function to show edit page
    ** recieve parameters
    *** $id to get category
    ** retrun view
    */
    public function editCategory($id)
    {
        $category = Category::find($id);
        return view('admin.editcategory', compact('category'));
    }

    /*
    ** function to update category
    ** recieve parameters
    *** $request to get form data
    *** $id to get category
    ** retrun edit page with session
    */
    public function updateCategory(Request $request, $id)
    {
        $this->validate($request,['category_name' => 'required']);
        $category = Category::find($id);
        $cat_name = $request->category_name;
        $checkCat = Category::where('category_name', $cat_name)->first();
        if(!$checkCat)
        {
            $category->category_name = $cat_name;
            $category->save();
            return redirect('editcategory/'.$category->id)->with('status', 'The '.$cat_name.' Category updated successfully');
        }
        else
        {
            return redirect('editcategory/'.$category->id)->with('status1', 'The '.$cat_name.' Category is already exist');
        }
    }

    /*
    ** function to delete category
    ** recieve parameters
    *** $id to get category
    ** return categories page with session
    */
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $cat_name = $category->category_name;
        $category->delete();
        return redirect('/categories')->with('status_d', 'The '.$cat_name.' Category has been deleted successfully');
    }

    /*
    ** function to view products by category
    ** recieve parameters
    *** $name to get product category name
    ** return view
    */
    public function viewByCat($name)
    {
        $categories = Category::get();
        $products = Product::where('product_category', $name)->get();
        return view('client.shop', compact(['categories', 'products']));
    }

}
