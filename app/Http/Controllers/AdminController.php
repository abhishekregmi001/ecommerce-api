<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use DB;


class AdminController extends Controller
{
    public function order($user_id)
    {
        if($user_id==-1)
        $data=DB::table('orders')->select("fullname","order_number","order_date","per_amount","quantity","order_status")->Join('costumers', 'costumers.id', '=', 'orders.user_id')->get();
        else
        $data=DB::table('orders')->select("fullname","order_number","order_date","per_amount","quantity","order_status")->Join('costumers', 'costumers.id', '=', 'orders.user_id')->where(['costumers.id'=>$user_id])->get();
        
        return response()->json([
            'message' => 'Successful',
            'user' => $data
        ], 200);
    }

    // public function update(Request $request,$user_id)
    // {
    //     if($user_id==-1)
    //     $data=DB::table('orders')->select("status")->Join('costumers', 'costumers.id', '=', 'orders.user_id')->get();
    //     else
    //     $data=DB::table('orders')->select("status")->Join('costumers', 'costumers.id', '=', 'orders.user_id')->where(['costumers.id'=>$user_id])->get();
    //     return response()->json([
    //         'message' => 'Successful',
    //         'user' => $data
    //     ], 200);
    // }
    public function update( Request $request, $id){
        $product = Order::where('user_id','=',auth()->id())->get();
        $product=Order::find($id);
        $product->per_amount = $request->per_amount;
        $product->order_date = $request->order_date;
        $product->quantity = $request->quantity;
        $product->save();
        
        return response()->json([
            'message' => 'Order update successfully',
            'product' => $product
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
