<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'user_id'=>'required',
            'order_number'=>'required',
            'per_amount'=>'required',
            'quantity'=>'required',
            'order_status'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $order =Order::create([
            'status' =>  $request->status,
            'user_id'=> $request->user_id,
            'order_number'=> $request->order_number,
            'per_amount'=> $request->per_amount,
            'order_date'=> now(),
            'quantity'=> $request->quantity,
            'order_status'=> $request->order_status
            ]);

        return response()->json([
            'message' => 'Order Added successfully',
            'product' => $order
        ], 201);
    }
    public function deleteorder($id)
    {
        $order=Order::findOrFail($id);
        $order->delete();
    }

    public function showorder($id)
    {
        $order=Order::findOrFail($id);
        return response()->json($cart);
    }
    public function updateOrder(Request $request, $id)
    {
        $data=Order::find($id);
        $data->update(['order_status'=>$request->status]);
        return response()->json([
            'message' => 'Order Updated successfully',
            'product' => $data
        ], 201);
    }


    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
