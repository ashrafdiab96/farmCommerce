<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * function to access acount after login
     * recieve parameters
     * $request to get the enterd data
     * @return response
    */
    public function accessAcount(Request $request) {
        $this->validate($request, ['email' => 'email|required', 'password' => 'required']);
        $client = Client::where('email', $request->email)->first();
        if($client) {
            if(Hash::check($request->password, $client->password)) {
                if($client->is_admin== 1) {
                    Session::put('Admin', $client);
                    return response()->json($client);
                } else {
                    return response()->json('You don not have permission to access this link');
                }
            } else {
                return response()->json('Incorrect password');
            }
        } else {
            return response()->json('This user is not exist');
        }
    }

    /**
     * function to logout
     * no parameters 
    */
    public function logout() {
        if (Session::has('Admin')) {
            Session::forget('Admin');
            return response()->json('Loggedout');
        }
    }

    /**
     * function to get all orders
     * no parameters
     * @return response
    */
    public function orders() {
        $orders = Order::get();
        return response()->json($orders);
    }

    /**
     * function to get specific order
     * recieve parameters
     * $id to get the order
     * @return response
    */
    public function order($id) {
        if (isset($order)) {
            $order = Order::find($id);
            return response()->json($order);
        } else {
            return response()->json('This order is not exist');
        }
    }

    /**
     * function to delete orders
     * recieve parameters
     * $id to get the order
     * return  redirect to orders page
     * @return response
    */
    public function deleteOrder($id) {
        $order = Order::find($id);
        if (isset($order)) {
            $order->delete();
            return response()->json($order);
        } else {
            return response()->json('This order is not exist');
        }
    }

    /**
     * function to get all clients
     * no parameters
     * @return response
    */
    public function clients()
    {
        $clients = Client::get();
        return response()->json($clients);
    }

    /**
     * function to get specific client
     * recieve parameters
     * $id to get the client
     * @return response
    */
    public function client($id)
    {
        $client = Client::find($id);
        if (isset($client)) {
            return response()->json($client);
        }
        return response()->json('This user is not exist');
    }

    /**
     * function to delete specific client
     * recieve parameters
     * $id to get the client
     * @return response
    */
    public function deleteClient($id) {
        $client = Client::find($id);
        if (isset($client)) {
            $client->delete();
            return response()->json($client);
        }
        return response()->json('This user is not exist');
    }

    /**
     * function to set client as admin
     * recieve parameters
     * $id to get the client
     * @return response
    */
    public function setAdmin($id) {
        $client = Client::where('id', $id)->first();
        if (isset($client)) {
            if ($client->is_admin == 0) {
                $client->is_admin = 1;
                $client->save();
                $msg = 'The client has been seted as admin';
                $data = [
                    'client' => $client,
                    'msg'    => $msg
                ];
                return response()->json($data);
            } else {
                return response()->json('This client is already admin');
            }
        } else {
            return response()->json('This client is not exist');
        }
    }

    /**
     * function to remove client as admin
     * recieve parameters
     * $id to get the client
     * @return response
    */
    public function removeAdmin($id) {
        $client = Client::where('id', $id)->first();
        if (isset($client)) {
            if ($client->is_admin == 1) {
                $client->is_admin = 0;
                $client->save();
                $msg = 'The client has been removed as admin';
                $data = [
                    'client' => $client,
                    'msg'    => $msg
                ];
                return response()->json($data);
            } else {
                return response()->json('This client is already not admin');
            }
        } else {
            return response()->json('This client is not exist');
        }
    }



}
