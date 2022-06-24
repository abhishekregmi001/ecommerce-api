<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;


class BlogCategoryController extends Controller
{
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cBlogCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Category'=>'required|unique:blog_categories,category_name',
            'Slug'=>'required',
            'Icon'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = BlogCategory::create([
                'category_name' => $request->Category,
                'slug'=>$request->Slug,
                'category_icon'=>$request->Icon,
                'is_primary'=>$request->IsPrimary,
                'status'=>$request->Flag,
                'created_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => ' Added successfully',
            'product' => $data
        ], 201);
    }
    public function uBlogCategory(Request $request,$id)
    {
        $data=BlogCategory::findorfail($id);

        $validator = Validator::make($request->all(), [
            'Category'=>'required|unique:blog_categories,category_name',
            'Slug'=>'required',
            'Icon'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'category_name' => $request->Category,
            'slug'=>$request->Slug,
            'category_icon'=>$request->Icon,
            'is_primary'=>$request->IsPrimary,
            'status'=>$request->Flag,
            'updated_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => ' Updated successfully',
            'product' => $data
        ], 201);
    }

    public function blogStatus(Request $request,$id)
    {
        $data=BlogCategory::find($id);
        $data->update([
            'status'=>$request->Status,
            'is_primary'=>$request->Flag,
        ]);
        return response()->json([
            'message' => ' Updated successfully',
            'product' => $data
        ], 200);
    }

    public function blogCategory()
    {
        $data=BlogCategory::select('category_name','slug','category_icon','is_primary','status')->get();
        return response()->json([
            'categories' => $data
        ], 200);
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
