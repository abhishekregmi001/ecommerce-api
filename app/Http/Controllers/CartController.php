<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Cart;
use App\Models\costumer;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{

    public function addcart(Request $request)
    {
        $quantity=product::where('id',$request->product_id)->pluck('quantity');    
        $quantity1=$quantity[0];
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity'=>"required|numeric|between:1,$quantity1",
            'per_amount'=>'required '
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if(costumer::where('id',$request->user_id)->exists()){
            if(product::where('id',$request->product_id)->exists())
                {
                    if(Cart::where('product_id',$request->product_id)->exists() ){
                        $cart=Cart::where('product_id','=',$request->product_id);
                        $cart->update([
                            'quantity'=>$request->quantity,
                            'per_amount'=>$request->per_amount,
                        ]);
                        return response()->json([
                            'message' => 'Cart updated successfully',
                            'product' => $cart
                        ], 200);
                    }
                    else
                    {
                        $cart = Cart::create([
                            'product_id' => $request->product_id,
                            'quantity' => $request->quantity,
                            'per_amount'=>$request->per_amount,
                            'user_id' => $request->user_id,
                            ]);
                
                        return response()->json([
                            'message' => 'Cart Added successfully',
                            'product' => $cart
                        ], 200);
                    }
                }
                else
                {
                    return response()->json([
                        'message' => 'product doesnt exist',
                    ], 202);
                }
            }
            else
            {
                return response()->json([
                    'message' => 'user doesnt exist',
                ], 200);  
            }
        }


    public function updatecart(Request $request,$id)
    {
        $cart=Cart::findorfail($id);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity'=>'required',
            'per_amount'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cart->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'per_amount'=>$request->per_amount,
            'user_id' => $request->user_id,
            ]);

        return response()->json([
            'message' => 'Cart Updated successfully',
            'product' => $cart
        ], 200);
    }

    public function deletecart($id)
    {
        $cart=Cart::findOrFail($id);
        $cart->delete();
    }

    public function showcart($id)
    {
        $cart=Cart::findOrFail($id);
        return response()->json($cart);
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
