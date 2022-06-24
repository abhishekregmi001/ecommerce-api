<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductSubCategoryController extends Controller
{
    
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPSCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required',
            'category_id'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = ProductSubCategory::create([
                'subcategory_name' => $request->subcategory_name,
                'category_id'=>$request->category_id,
                'created_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => 'Product SubCategory Created successfully',
            'product' => $product
        ], 201);
    }
    public function updatePSCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required',
            'category_id'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product->update([
                'subcategory_name' => $request->subcategory_name,
                'category_id'=>$request->category_id,
                'created_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => 'Product SubCategory Created successfully',
            'product' => $product
        ], 201);
    }

    public function Pscdelete($id)
    {
        $product=ProductSubCategory::findOrFail($id);
        $product->delete();
    }
    public function Pscshow($id)
    {
        $product=ProductSubCategory::findOrFail($id);
        return response()->json($product);
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