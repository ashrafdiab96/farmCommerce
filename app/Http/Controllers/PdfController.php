<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class PdfController extends Controller
{
    /*
    ** function to convert order html to pdf
    ** recieve parameters
    *** $id to get the order
    ** return redirect to order page
    */
    public function viewPdf($id)
    {
        // make session of id
        Session::put('id', $id);
        try{
            // handel the format and assign it to $pdf variable
            $pdf = \App::make('dompdf.wrapper')->setPaper('a4', 'landscape');
            // convert order to html then convert html into pdf
            $pdf->loadHTML($this->convert_orders_data_to_html());

            return $pdf->stream();
        }
        catch(\ Exception $e){
            return redirect('/orders')->with('error', $e->getMessage());
        }
    }

    /*
    ** function to convert order data to html
    ** no parameters
    ** return $output variable
    */
    public function convert_orders_data_to_html(){
        // get orders via id
        $orders = Order::where('id',Session::get('id'))->get();
        // get each order data
        foreach($orders as $order){
            $name = $order->name;
            $address = $order->address;
            $date = $order->created_at;
            $phone = $order->phone;
            $email = $order->email;
            $method = $order->card_name;
        }
        // convert serialize order to unserialize order
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        $output = '<link rel="stylesheet" href="frontend/css/style.css">
                        <table class="table">
                            <thead class="thead">
                                <tr class="text-left">
                                    <th>Client Name : '.$name.'<br> Address : '.$address.' <br> Date : '.$date.'</th>
                                    <th class="text-right"> Email : '.$email.'<br> phone : '.$phone.' <br> Payment method : '.$method.'</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>Image</th>
                                    <th>Product name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>';
        foreach($orders as $order){
            foreach($order->cart->items as $item){
                $output .= '<tr class="text-center">
                                <td class="image-prod"><img src="product_images/'.$item['product_image'].'" alt="" style = "height: 80px; width: 80px;"></td>
                                <td class="product-name">
                                    <h3>'.$item['product_name'].'</h3>
                                </td>
                                <td class="price">$ '.$item['product_price'].'</td>
                                <td class="qty">'.$item['qty'].'</td>
                                <td class="total">$ '.$item['product_price']*$item['qty'].'</td>
                            </tr><!-- END TR-->
                            </tbody>';
            }
            $totalPrice = $order->cart->totalPrice; 
        }
        $output .='</table>';
        $output .='<table class="table">
                        <thead class="thead">
                            <tr class="text-center">
                                    <th>Total</th>
                                    <th>$ '.$totalPrice.'</th>
                            </tr>
                        </thead>
                    </table>';
        return $output;
    }

}
