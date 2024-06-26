<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sales_orders;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sales_orders::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,product_id',
            'order_value' => 'required|numeric|between:0,9999999999.99'
        ]);

        $request->request->add(['order_id' => $this->generateOrderID()]);
        $request->request->add(['process_id' => rand(1, 10)]);

        $data = Sales_orders::create($request->all());
        $user = User::where('id', $data->customer_id)->first();

        $endData = [
            'Order_ID' => $data->order_id,
            'Customer_Name' => $user->name,
            'Order_Value' => $data->order_value,
            'Order_Date' => $data->created_at,
            'Order_Status' => 'Proccessing',
            'Process_ID' => $data->process_id,
        ];
        $this->sendToThirdPartyAPI($endData);


        return response()->json(['message' => 'Order Created successfully', 'data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateOrderID()
    {

        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsNum = strlen($chars);

        $code = '';

        while (strlen($code) < 10) {
            $position = rand(0, $charsNum - 1);
            $char = $chars[$position];
            $code = $code . $char;
        }

        if (Products::where('product_id', '77' . $code)->exists()) {
            $this->generateOrderID();
        }

        return '77' . $code;
    }

    private function sendToThirdPartyAPI($data)
    {
        $client = new Client();

        try {
            // $response = $client->post('https://175c8965d0d7487b9e916001b25652a7.api.mockbin.io/', [
            //     'json' => $data,
            // ]);
            $response = $client->post('https://wibip.free.beeceptor.com/order', [
                'json' => $data,
            ]);

            $body = $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('Error sending data to third-party API: ' . $e->getMessage());
        }
    }
}
