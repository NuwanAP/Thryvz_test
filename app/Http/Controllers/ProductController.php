<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Products::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->request->add(['product_id' => $this->generateProductID()]);
        $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'product_name' => 'required',
            'product_value' => 'required|numeric|between:0,9999999999.99'
        ]);

        return Products::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pid)
    {
        $product = Products::where('product_id', $pid)->first();
        if ($product) {
            return $product;
        } else {
            return response('Data NotFound!', Response::HTTP_NOT_FOUND);
        }
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

    public function generateProductID()
    {

        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsNum = strlen($chars);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charsNum - 1);
            $char = $chars[$position];
            $code = $code . $char;
        }

        if (Products::where('product_id', $code)->exists()) {
            $this->generateProductID();
        }

        return $code;
    }
}
