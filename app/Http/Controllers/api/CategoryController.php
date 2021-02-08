<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * function to show all categories 
     * no parameters
     * @return json
    **/
    public function categories() {
        $categories = Category::get();
        return response()->json($categories);
    }

    /**
     * function to show specific category
     * recieve parameters
     * $id to get the category
     * @return json
    **/
    public function category($id) {
        $category = Category::find($id);
        if (!isset($category)) {
            return response()->json('This category is not exist');
        }
        return response()->json($category);
    }

    /**
     * function to store new category
     * recieve parameters
     * $request to get the data
     * @return json
    **/
    public function storeCategory(Request $request) {
        $cat_name = $request->name;
        $category = new Category;
        $category->category_name = $cat_name;
        $category->save();
        return response()->json($category);
    }

    /**
     * function to update category
     * recieve parameters
     * $request to get the data
     * $id to get the wanted update category
     * @return json
    **/
    public function updateCategory(Request $request, $id) {
        $category = Category::find($id);
        if (!isset($category)) {
            return response()->json('This category is not exist');
        }
        $category->category_name = $request->name;
        $category->save();
        return response()->json($category);
    }

    /**
     * function to delete category
     * recieve parameters
     * $id to get the category
     * @return json
    **/
    public function deleteCategory($id) {
        $category = Category::find($id);
        if (!isset($category)) {
            return response()->json('This category is not exist');
        }
        $category->delete();
        return response()->json($category);
    }

}
