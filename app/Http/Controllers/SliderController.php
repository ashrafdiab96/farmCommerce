<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    /*
    ** function to show all sliders
    ** no parameters
    ** return view with inserted sliders
    */
    public function sliders()
    {
        $sliders = Slider::get();
        return view('admin.sliders', compact('sliders'));
    }

    /*
    ** function display form, to add new slider
    ** no parameters
    ** return view
    */
    public function addSlider()
    {
        return view('admin.addslider');
    }

    /*
    ** function to save the slider data in database
    ** recieve parameter
    *** $request, to get the form data
    ** return success message redirected to add slider page
    */
    public function saveSlider(Request $request)
    {
        // get enterd data
        $desc1 = $request->desc_one;
        $desc2 = $request->desc_two;
        // create new slider
        $slider = new Slider();
        // store the enterd data in the database
        $slider->slider_desc1 = $desc1;	
        $slider->slider_desc2 = $desc2;
        $slider->status = 0;
        /*
        ** check if there is image, store it
        ** if there no images, store noimage.jpg file
        */
        if($request->hasFile('slider_image'))
        {
            // get the image name
            $image_name = time().'_'.$request->slider_image->getClientOriginalName();
            // upload image to the path
            $image_path = $request->file('slider_image')->move('slider_images', $image_name);
            // store the image in the database
            $slider->slider_image = time().'_'.$request->slider_image->getClientOriginalName();
        }
        else
        {
            $image_name = 'noimage.jpg';
            $slider->slider_image = 'noimage.jpg';
        }
        $slider->save();
        return redirect('/addslider')->with('status_s_a', 'The slider added successfully');
    }

    /*
    ** function to display edit form
    ** recieve parameters
    *** $id -> to return slider data
    ** return view with slider and categories
    */
    public function editSlider($id)
    {
        $slider = Slider::find($id);
        return view('admin.editslider', compact('slider'));
    }

    /*
    ** function to store updated data
    ** recieve parameters
    *** $request to get the form data 
    *** $id to select the slider
    ** return view
    */
    public function updateSlider(Request $request, $id)
    {
        // $this->validate($request,['product_name' => 'required',
        //                           'product_price' => 'required',
        //                           'product_image' => 'image|nullable|max:1999']);
        // get the product stored data
        $slider = Slider::find($id);
        // store the inputs data in the database
        $slider->slider_desc1 = $request->desc_one;
        $slider->slider_desc2 = $request->desc_two;
        $slider->status = 0;
        // check if there is photo
        if($request->hasFile('slider_image'))
        {
            // get file name and generate unique name
            $image_name = time().'_'.$request->slider_image->getClientOriginalName();
            // upload images
            $filePath = $request->file('slider_image')->move('slider_images', $image_name);
            // store the image in database
            $slider->slider_image = time().'_'.$request->slider_image->getClientOriginalName();
        }
        else
        {
            // get the old image
            $old_image = $slider->slider_image;
            $slider->slider_image = $old_image;
        }
        // save the slider
        $slider->save();
        return redirect('/sliders')->with('slider_u', 'The slider has been updated successfully');
    }

    /*
    ** function to delete slider
    ** recieve parameters
    *** $id to get the selected slider
    ** return view with success message
    */
    public function deleteSlider($id)
    {
        $slider = Slider::find($id);
        if (isset($slider))
        {
            $slider->delete();
            return redirect('/sliders')->with('slider_d', 'The slider has been deleted successfully');
        }
        else
        {
            return redirect('/sliders')->with('slider_nd', 'Unable to delete this slider right now');
        }
    }

    /*
    ** function to activate sliders
    ** recieve parameters
    *** $id to get the slider
    */
    public function activateSlider($id)
    {
        $slider = Slider::find($id);
        if(isset($slider))
        {
            if($slider->status == 0)
            {
                $slider->status = 1;
                $slider->save();
                return redirect('/sliders')->with('slider_a', 'The slider has been activated successfully');
            }
            else
            {
                return redirect('/sliders')->with('slider_na', 'The slider is already activated');
            }
        }
        else
        {
            return redirect('/sliders')->with('product_na', 'Unable to activate the slider right now');
        }
    }

    /*
    ** function to deactivate products
    ** recieve parameters
    *** $id to get the product
    */
    public function deactivateSlider($id)
    {
        $slider = Slider::find($id);
        if(isset($slider))
        {
            if($slider->status == 1)
            {
                $slider->status = 0;
                $slider->save();
                return redirect('/sliders')->with('slider_da', 'The slider has been deactivated successfully');
            }
            else
            {
                return redirect('/sliders')->with('slider_da', 'The slider is already deactivated');
            }
        }
        else
        {
            return redirect('/sliders')->with('slider_nda', 'Unable to deactivate the slider right now');
        }
    }
}
