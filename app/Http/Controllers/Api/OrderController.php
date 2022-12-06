<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Create Order
     *
     * @param Request $request
     * @return Response
     *
     */

    public function createOrder(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'address' => 'required',
                'contactNo' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation Error",
                    'error' => $validator->errors()

                ], 401

                );
            }
            $ordr = Order::create([
                'user_id' => auth()->user()->id,
                'address' => $request->address,
                'contact' => $request->contactNo,

            ]);
            foreach (Cart::where('user_id', auth()->user()->id)->get() as $item) {

                $ordr = OrderItems::create([
                    'order_id' => $ordr->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product_price,

                ]);

            }

            return response()->json([
                'status' => true,
                'message' => "Order Created Successfully",

            ], 200

            );

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()

            ], 500

            );
        }


    }

}
