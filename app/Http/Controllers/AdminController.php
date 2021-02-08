<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Client;

class AdminController extends Controller
{
    /*
    ** function to display the dashboard
    ** no parameters
    ** return view
    */
    public function dashboard()
    {
        if (Session::has('Admin'))
        {
            return view('admin.dashboard');
        }
        else
        {
            return redirect('/admin/login');
        }
    }

    /*
    ** function to show login page
    ** no parameters
    ** return view
    */
    public function login()
    {
        if(Session::has('Admin'))
        {
            return redirect('/admin');
        }
        return view('admin.login');
    }

    /*
    ** function to login admin
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
                if($client->is_admin== 1)
                {
                    Session::put('Admin', $client);
                    return redirect('/admin');
                }
                else
                {
                    return redirect('/');    
                }
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
    ** function to display orders
    ** no parameters
    ** return view
    */
    public function orders()
    {
        $orders = Order::get();
        // convert the serialize cart to unserialize and get the items name
        $orders->transform(function($order, $key)
        {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('admin.orders', compact('orders'));
    }

    /*
    ** function to display clients
    ** no parameters
    ** return view
    */
    public function clients()
    {
        $clients = Client::get();
        return view('admin.clients', compact('clients'));
    }

    /*
    ** function to set user to admin
    ** recieve parameters
    *** $id to get the user
    ** return redirect
    */
    public function setAdmin($id)
    {
        $client = Client::where('id', $id)->first();
        if (isset($client))
        {
            if ($client->is_admin == 0)
            {
                $client->is_admin = 1;
                $client->save();
                return back()->with('client_s', ''.$client->name.' seted as admin');
            }
            else
            {
                return back()->with('client_ns', ''.$client->name.' is already admin');
            }
        }
        else
        {
            return back()->with('client_ns', ' This user is not exist');
        }
    }

    /*
    ** function to remove user as admin
    ** recieve parameters
    *** $id to get the user
    ** return redirect
    */
    public function removeAdmin($id)
    {
        $client = Client::where('id', $id)->first();
        if (isset($client))
        {
            if ($client->is_admin == 1)
            {
                $client->is_admin = 0;
                $client->save();
                return back()->with('client_s', ''.$client->name.' removed as admin');
            }
            else
            {
                return back()->with('client_ns', ''.$client->name.' is not admin');
            }
        }
        else
        {
            return back()->with('client_ns', ' This user is not exist');
        }
    }

    /*
    ** function to delete client
    ** recieve parameters
    *** $id to get the client
    ** return  redirect to clients page
    */
    public function deleteClient($id)
    {
        $client = Client::find($id);
        if (isset($client))
        {
            $client->delete();
            return redirect('/clients')->with('client_d', 'The client has been deleted successfully');
        }
        else
        {
            return redirect('/clients')->with('client_nd', 'Unable to delete this client right now');
        }
    }

    /*
    ** function to delete orders
    ** recieve parameters
    *** $id to get the order
    ** return  redirect to orders page
    */
    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (isset($order))
        {
            $order->delete();
            return redirect('/orders')->with('order_d', 'The order has been deleted successfully');
        }
        else
        {
            return redirect('/orders')->with('order_nd', 'Unable to delete this order right now');
        }
    }

    /*
    ** function logout
    ** no parameters
    ** return view
    */
    public function logout()
    {
        if(Session::has('Admin'))
        {
            Session::forget('Admin');
            return redirect('/admin/login');
        }
        return redirect('/admin/login');
    }

}



