<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Client;
use App\Mail\SendMail;
use Stripe\Charge;
use Stripe\Stripe;
use App\Cart;

class ClientController extends Controller
{
    /*
    ** function to show home page
    ** no parameters
    ** return view
    */
    public function home()
    {
        $sliders = Slider::get();
        $products = Product::get();
        return view('client.home', compact(['sliders', 'products']));
    }

    /*
    ** function to show cart page
    ** no parameters
    ** return view
    */
    public function cart()
    {
        // check if we don't have cart session, return cart page
        if(!Session::has('cart'))
        {
            return view('client.cart');
        }
        // check if we have a cart -> get it's data in session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // create an object from Caert class
        $cart = new Cart($oldCart);
        return view('client.cart', ['products' => $cart->items, 'sum' => 0]);
    }

    /*
    ** function to show login page
    ** no parameters
    ** return view
    */
    public function login()
    {
        if(Session::has('client'))
        {
            return redirect('/');
        }
        return view('client.login');
    }

    /*
    ** function to login
    ** recieve parameters
    *** $request to get the account data from the form
    ** return redirect to the new account with success message
    */
    public function accessAccount(Request $request)
    {
        $this->validate($request, ['email' => 'email|required', 'password' => 'required']);
        $client = Client::where('email', $request->email)->first();
        if($client)
        {
            if(Hash::check($request->password, $client->password))
            {
                Session::put('client', $client);
                return redirect('/');
            }
            else
            {
                return back()->with('error', 'Incorrect password');
            }
        }
        else
        {
            return back()->with('error', 'This account does not exist');
        }
    }

    /*
    ** function logout
    ** no parameters
    ** return view
    */
    public function logout()
    {
        if(Session::has('client'))
        {
            Session::forget('client');
            return redirect('/');
        }
        return redirect('/login');
    }

    /*
    ** function to show signup page
    ** no parameters
    ** return view
    */
    public function signup()
    {
        if(Session::has('client'))
        {
            return redirect('/');
        }
        return view('client.signup');
    }

    /*
    ** function to create account
    ** recieve parameters
    *** $request to get the account data from the form
    ** return redirect
    */
    public function createAccount(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'email|required|unique:clients', 
        'password' => 'required|min:4', 'image' => 'image|nullable|max:1999']);
        if($request->has('agree'))
        {
            $client = new Client();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->is_admin = 0;
            $client->password = bcrypt($request->password);
            if($request->hasFile('image'))
            {
                // get file name and generate unique name
                $image_name = time().'_'.$request->image->getClientOriginalName();
                // upload images
                $filePath = $request->file('image')->move('client_images', $image_name);
                // store the image in database
                $client->image = time().'_'.$request->image->getClientOriginalName();
            }
            else
            {
                // if there is no image, put a default image
                $image_name = 'noimage.jpg';
                $client->image = time().'_'.$request->image->getClientOriginalName();
            }
            $client->save();
            return back()->with('created', 'Your account has been created successfully !');
        }
        else
        {
            return back()->with('notAgree', 'Your must agree to our terms');
        }
    }

    /*
    ** function to show client profile
    ** recieve parameters
    *** $id to show the client data
    ** return view
    */
    public function showProfile($id)
    {
        $client = Client::find($id);
        return view('client.profile', compact('client'));
    }

    /*
    ** function to show edit client profile form
    ** recieve parameters
    *** $id to show the client data
    ** return view
    */
    public function editProfile($id)
    {
        $client = Client::find($id);
        return view('client.editprofile', compact('client'));
    }

    /*
    ** function to save client profile editing data
    ** recieve parameters
    *** $request to get the form enterd data
    *** $id to get the client data
    ** return view
    */
    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'email|required:clients', 'image' => 'image|nullable|max:1999']);
        $client = Client::find($id);
        $client->name = $request->name;
        $client->email = $request->email;
        if($request->hasFile('image'))
        {
            // get file name and generate unique name
            $image_name = time().'_'.$request->image->getClientOriginalName();
            // upload images
            $filePath = $request->file('image')->move('client_images', $image_name);
            // store the image in database
            $client->image = time().'_'.$request->image->getClientOriginalName();
        }
        else
        {
            // get the old image
            $old_image = $client->image;
            $client->image = $old_image;
        }
        $client->save();
        return redirect('showprofile/'.$client->id.'')->with('profile_u', 'Profile updated successfully');
    }


    /*
    ** function to show shop page
    ** no parameters
    ** return view
    */
    public function shop()
    {
        $products = Product::get();
        $categories = Category::get();
        return view('client.shop', compact(['products', 'categories']));
    }

    /*
    ** function to update quantity of items
    ** recieve parameters
    *** $request to get the qty number
    ** return view
    */
    public function updateQty(Request $request)
    {
        // check if we have a cart -> get it's data in session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // create an object from Caert class
        $cart = new Cart($oldCart);
        // pass parameters to the update() function
        $cart->updateQty($request->id, $request->quantity);
        // put the cart data in the session
        Session::put('cart', $cart);
        return redirect('/cart');
    }

    /*
    ** function to show checkout page if we have items in the cart
    ** no parameters
    ** return redirect or view
    */
    public function checkout()
    {
        // check if user login or not
        if(!Session::has('client'))
        {
            return redirect('/login');
        }
        // check if we don't have items in cart, don;t go to checkout
        if(!Session::has('cart'))
        {
            return redirect('/cart');
        }
        return view('client.checkout');
    }

    /*
    ** function to complete checkout
    ** if checkout success, store the order data
    ** recieve parameters
    *** $request to get payment from data
    ** return view
    */
    public function postCeckout(Request $request)
    {
        // check if we don't have items in cart, don;t go to checkout
        if(!Session::has('cart'))
        {
            return redirect('/cart');
        }
        // check if we have a cart -> get it's data in session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // create an object from Caert class
        $cart = new Cart($oldCart);
        Stripe::setApiKey('sk_test_51IFLCAEjxfACxx9dRt1W4ahLCxeAjFsuklNrDWRyxuADtstzNubhlEliiOAEE6B2MV21TvROUGywMsuWDuaq4SAu00HA1x6MB1');
        try{
            $charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtainded with Stripe.js
                "description" => "Test Charge"
            ));
            // store order data
            $order = new Order();
            $order->name = $request->name;
            $order->address = $request->address;
            $order->card_name = $request->card_name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->cart = serialize($cart);
            $order->payment_id = $charge->id;
            $order->save();
            // Mailing system
            // get the current order which confirmed (checkout)
            $orders = Order::where('payment_id', $charge->id)->get();
            // convert the serialize cart to unserialize and get the items name
            $orders->transform(function($order, $key)
            {
                $order->cart = unserialize($order->cart);
                return $order;
            });
            // get the client email
            $email = Session::get('client')->email;
            // send mail to client mail
            Mail::to($email)->send(new SendMail($orders));

        } catch(\Exception $e){
            Session::put('error', $e->getMessage());
            return redirect('/checkout');
        }
        Session::forget('cart');
        return redirect('/cart')->with('success', 'Purchase accomplished successfully !');
    }

    /*
    ** function to remove item from cart
    ** recieve parameters
    *** $id to get the item
    ** return view
    */
    public function removeItem($id)
    {
        // check if we have a cart -> get it's data in session
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // create an object from Caert class
        $cart = new Cart($oldCart);
        // pass parameters to the removeItem() function
        $cart->removeItem($id);
        // check if we have items in the cart or not
        if(count($cart->items) > 0)
        {
            Session::put('cart', $cart);
        }
        else
        {
            Session::forget('cart');
        }
        return redirect('/cart');
    }

}

