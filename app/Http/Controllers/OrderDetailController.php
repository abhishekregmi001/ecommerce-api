<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderDetailController extends Controller
{
    public function addod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'product_id'=>'required',
            'quantity'=>'required',
            'per_amount'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $order =OrderDetail::create([
            'order_id' =>  $request->order_id,
            'product_id'=> $request->product_id,
            'quantity'=> $request->quantity,
            'per_amount'=> $request->per_amount,
            ]);

        return response()->json([
            'message' => 'OrderDetail Added successfully',
            'product' => $order
        ], 201);
    }
    public function deleteod($id)
    {
        $od=OrderDetail::findOrFail($id);
        $od->delete();
    }

    public function showod($id)
    {
        $show=OrderDetail::findOrFail($id);
        return response()->json($show);
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
