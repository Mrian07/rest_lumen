<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Customers;
use App\Orders;
use App\Products;

class OrderController extends Controller
{
    public function __construct()
    {
        
    }

    public function getAll()
    {
        $data = Orders::All();
        Log::info("Get all data Orders");
        return response()->json(["messages"=>"success retrieve data","status" => true,"data"=> $data], 200);
    }

    public function getById($id)
    {
        $data = Orders::find($id);
        if(!$data)
        {
            Log::error("Data not found");
            return response()->json(["messages"=>"failed retrieve data","status" => false,"data"=> $data], 404);
        }
        Log::info("Get data Orders");
        return response()->json(["messages"=>"success retrieve data","status" => true,"data"=> $data], 200);
    }

    public function insert(Request $request)
    {
        // $this->validate($request,
        // [
        //     'data.attributes.order_detail.*' => 'present|array',
        //     'data.user_id' => 'required',
        //     'status' => 'required'
        // ]);
        $request_data = $request->all();
        $order = new Orders();
        $order->user_id = $request_data['data']['attributes']['user_id'];
        $order->status = 'pending';

        if($order->save())
        {
            return response()->json(["data"=>"tes"]);
            // $idInserted = $order->id;
            // $this->validate($request,
            // [
            //     'product_id' => 'required',
            //     'quantity' => 'required'
            // ]);

            
            // $data_product = $request_data['data']['attributes']['order_detail'];
            // foreach($data_product as $dp)
            // {
            //     $product = new Products();
            //     $product->order_id = $idInserted;
            //     $product->product_id = $dp->product_id;
            //     $product->quantity = $dp->quantity;
            //     $product->save();
            // }

            // if($product->save())
            // {
            //     $idProduct = $product->id;
            //     // $dataProduct = Products::find($idProduct);
            //     Log::info("Success input order");
            //     return response()->json(
            //         [
            //             "data"=>[
            //                 "attributes"=>[
            //                     "user_id" =>$order->user_id,
            //                     "order_detail" =>$data_product
            //                 ]
            //             ]
            //         ], 201
            //     );
            // }   
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'full_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone_number'=> 'required'
        ]);

        $customer = Orders::find($id);

        if(!$customer)
        {
            Log::error("Data not found");
            return response()->json(["messages"=>"failed retrieve data","status" => false,"data"=> ''], 404);
        }
        $customer->fullname = $request->input('full_name');
        $customer->username = $request->input('username');
        $customer->email = $request->input('email');
        $customer->phone_number = $request->input('phone_number');

        if($customer->save())
        {
            Log::info("Success input customer");
            return response()->json(
                [
                    "data"=>[
                        "attributes"=>[
                            "full_name" =>$request->input('full_name'),
                            "username" =>$request->input('username'),
                            "email" =>$request->input('email'),
                            "phone_number" =>$request->input('phone_number')
                        ]
                    ]
                        ], 201
            );
        }
    }

    public function delete($id)
    {
        $data = Orders::find($id);
        if(!$data)
        {
            Log::error("Data not found");
            return response()->json(["messages"=>"failed delete data","status" => false,"data"=> ''], 404);
        }

        if($data->delete())
        {
            Log::info('Data success delete');
            return response()->json(["messages"=>"success delete data","status" => true,"data"=> $data], 200);
        }
    }
}