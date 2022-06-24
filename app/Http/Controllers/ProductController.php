<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use Auth;
use Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    private ProductRepositoryInterface $ProductRepository;

    public function __construct(ProductRepositoryInterface $ProductRepository) 
    {
        $this->ProductRepository = $ProductRepository;
    }
    
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'subcategory_id'=>'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = $request->only([
                'product_name',
                'subcategory_id',
                'description',
                'discount',
                'price',
                'quantity',
                'product_excerpt',
                'banner',
                'category_id',
                'created_by'
                // 'created_by' => Auth::user()->id,
            ]);

            return response()->json(
                [
                    'data' => $this->ProductRepository->addProduct($product)
                ],
                );
    }
    public function updateProduct(Request $request,$id)
    {

        $product = $request->only([
            'product_name',
            'subcategory_id',
            'description',
            'discount',
            'price',
            'quantity',
            'product_excerpt',
            'banner',
            'category_id',
            'created_by'
            ]);

        return response()->json([
            'message' => 'Product Updated successfully',
            'data' => $this->ProductRepository->updateProduct($product)
        ], 201);
    }

    public function Pdelete($id)
    {
        $this->ProductRepository->Pdelete($id);
    }
    public function searchProduct(Request $request)
    {
        if(isset($request->productName))
        {
            $p=DB::table('products')
        ->join('product_sub_categories','product_sub_categories.id','=','products.subcategory_id')
        ->join('product_categories','product_categories.id','=','products.category_id')
        ->select('product_sub_categories.category_id','subcategory_id','products.id','product_name','subcategory_name','category_name','discount','price')
        ->where('product_name',$request->productName)->get();
        return response()->json($p);
        }
        if(isset($request->categoryName))
        {
            $p=DB::table('product_categories')

            ->where('category_name',$request->categoryName)->get();
            return response()->json($p);
        }
        if(isset($request->subcategoryName))
        {
            $p=DB::table('product_sub_categories')

            ->where('subcategory_name',$request->subcategoryName)->get();
            return response()->json($p);
        }
    }
    public function product_info($id)
    {
        $p=Product::find($id);
        return response()->json($p);
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