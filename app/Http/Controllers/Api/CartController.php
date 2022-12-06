<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Add Products to Cart
     *
     * @param Request $request
     * @return Cart
     *
     */

    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'product_price' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation Error",
                'error' => $validator->errors()

            ], 401

            );
        }

        $cart = Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,


        ],
            ['qty' =>  $request->qty,'product_price' => $request->product_price]
        );


        return response()->json([
            'status' => true,
            'cart' => $this->getCartList($request->user_id),

        ], 200

        );


    }

    /**
     *
     * Remove From Cart
     * @param Request $request
     * @return Response
     *
     */

    public function removeCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation Error",
                'error' => $validator->errors()

            ], 401

            );
        }

        $delete = Cart::where(['user_id'=>$request->user_id,'product_id'=>$request->product_id])->delete();


        return response()->json([
            'status' => true,
            'cart' => $this->getCartList($request->user_id),

        ], 200

        );




    }


    private function getCartList($user_id)
    {
        $updatedCart = Cart::where('user_id',$user_id)->get();

        $cartList = array();

        foreach ($updatedCart as $cart){

            $cartList [] = array(

                'product_id' => $cart->product_id,
                'product_name' => $cart->product->name,
                'qty' => $cart->qty,


            );

        }

        return $cartList;


    }



}
