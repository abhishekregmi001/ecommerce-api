<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductCategoryController extends Controller
{
    
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = ProductCategory::create([
                'category_name' => $request->category_name,
                'created_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => 'Product Category Created successfully',
            'product' => $product
        ], 201);
    }
    public function Pcdelete($id)
    {
        $product=ProductCategory::findOrFail($id);
        $product->delete();
    }
    public function Pcshow($id)
    {
        $product=ProductCategory::findOrFail($id);
        return response()->json($product);
    }
    public function updatePCategory(Request $request, $id)
    {
        $product=ProductCategory::findorfail($id);
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product->update([
                'category_name' => $request->category_name,
                'updated_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => 'Product Category Updated successfully',
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