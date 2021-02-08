<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * show all clients
     * no parameters
     * @return response 
    **/
    public function clients () {
        $clients = Client::get();
        return response()->json($clients);
    }

    /**
     * show all clients
     * recieve parameters
     * $request to get client data
     * @return response 
    **/
    public function saveClient (Request $request) {
        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->is_admin = 0;
        $client->password = bcrypt($request->password);
        if($request->hasFile('image')) {
            $image_name = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->file('image')->move('client_images', $image_name);
            $client->image = time().'_'.$request->image->getClientOriginalName();
        }
        else {
            $image_name = 'noimage.jpg';
            $client->image = $image_name;
        }
        $client->save();
        $msg = 'Your account has been created successfully !';
        $data = [
            'Client' => $client,
            'msg'    => $msg
        ];
        return response()->json($data);
    }

    /**
     * show all clients
     * recieve parameters
     * $id to get the client
     * @return response 
    **/
    public function client ($id) {
        $client = Client::find($id);
        if ($client) {
            return response()->json($client);
        }
        return response()->json('This client is not exist in database');
    }

    /**
     * show all clients
     * recieve parameters
     * $request to get client data
     * $id to get the wanted client to edit
     * @return response 
    **/
    public function updateClient (Request $request, $id) {
        $client = Client::find($id);
        $client->name = $request->name;
        $client->email = $request->email;
        if($request->hasFile('image'))
        {
            $image_name = time().'_'.$request->image->getClientOriginalName();
            $filePath = $request->file('image')->move('client_images', $image_name);
            $client->image = time().'_'.$request->image->getClientOriginalName();
        }
        else
        {
            $old_image = $client->image;
            $client->image = $old_image;
        }
        $client->save();
        $msg = 'Profile updated successfully';
        $data = [
            'Client' => $client,
            'msg'    => $msg
        ];
        return response()->json($data);
    }



}
