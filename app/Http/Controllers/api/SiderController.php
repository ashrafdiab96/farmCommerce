<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SiderController extends Controller
{
    /**
     * functions to show all sliders
     * no parameters
     * @return response 
    **/
    public function sliders () {
        $sliders = Slider::get();
        if ($sliders) {
            return response()->json($sliders);
        }
        return response()->json('No sliders to get !');
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $request to get the new slider data
     * @return response 
    **/
    public function saveSlider (Request $request) {
        $desc1 = $request->desc_one;
        $desc2 = $request->desc_two;
        $slider = new Slider();
        $slider->slider_desc1 = $desc1;	
        $slider->slider_desc2 = $desc2;
        $slider->status = 0;
        if($request->hasFile('slider_image'))
        {
            $image_name = time().'_'.$request->slider_image->getClientOriginalName();
            $image_path = $request->file('slider_image')->move('slider_images', $image_name);
            $slider->slider_image = time().'_'.$request->slider_image->getClientOriginalName();
        }
        else
        {
            $image_name = 'noimage.jpg';
            $slider->slider_image = 'noimage.jpg';
        }
        $slider->save();
        $msg = 'The slider added successfully';
        $data = [
            'Slider' => $slider,
            'msg'    => $msg
        ];
        return response()->json($data);
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $id to get the slider
     * @return response 
    **/
    public function slider ($id) {
        $slider = Slider::find($id);
        if ($slider) {
            return response()->json($slider);
        }
        return response()->json('This slider is not exist');
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $request to get the slider edited data
     * $id to get the wanted slider to edit
     * @return response 
    **/
    public function updateSlider (Request $request, $id) {
        $slider = Slider::find($id);
        if ($slider) {
            $slider->slider_desc1 = $request->desc_one;
            $slider->slider_desc2 = $request->desc_two;
            $slider->status = 0;
            if ($request->hasFile('slider_image')) {
                $image_name = time().'_'.$request->slider_image->getClientOriginalName();
                $filePath = $request->file('slider_image')->move('slider_images', $image_name);
                $slider->slider_image = time().'_'.$request->slider_image->getClientOriginalName();
            } else {
                $old_image = $slider->slider_image;
                $slider->slider_image = $old_image;
            }
            $slider->save();
            $msg = 'Updated successfully';
            $data = [
                'Slider' => $slider,
                'msg'    => $msg
            ];
            return response()->json($data);
        }
        return response()->json('This slider is not exist');
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $id to get the slider
     * @return response 
    **/
    public function activateSlider ($id) {
        $slider = Slider::find($id);
        if(isset($slider)) {
            if($slider->status == 0) {
                $slider->status = 1;
                $slider->save();
                return response()->json('Slider activated successfuy');
            } else {
                return response()->json('The slider is already activate');
            }
        } else {
            return response()->json('This slider is not exist');
        }
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $id to get the slider
     * @return response 
    **/
    public function deactivateSlider ($id) {
        $slider = Slider::find($id);
        if(isset($slider)) {
            if($slider->status == 1) {
                $slider->status = 0;
                $slider->save();
                return response()->json('Slider deactivated successfuy');
            } else {
                return response()->json('The slider is already deactivate');
            }
        } else {
            return response()->json('This slider is not exist');
        }
    }

    /**
     * functions to show all sliders
     * recieve parameters
     * $id to get the slider
     * @return response 
    **/
    public function deleteSlider ($id) {
        $slider = Slider::find($id);
        if (isset($slider)) {
            $slider->delete();
            $msg = 'Slider deleted successfully';
            $data = [
                'Slider' => $slider,
                'msg'    => $msg
            ];
            return response()->json($data);
        } else {
            return response()->json('This slider is not exist');
        }
    }



}
