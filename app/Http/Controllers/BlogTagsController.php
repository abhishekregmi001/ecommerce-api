<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogTags;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class BlogTagsController extends Controller
{
     /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createblogtags(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Tags'=>'required|unique:blog_tags,tag_name',
            'Slug'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = BlogTags::create([
                'tag_name' => $request->Tags,
                'slug'=>$request->Slug,
                'is_trending'=>$request->IsTrending,
                'status'=>$request->Flag,
                'created_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => ' Added successfully',
            'product' => $data
        ], 200);
    }
    public function updateblogtags(Request $request,$id)
    {
        $data=BlogTags::findorfail($id);

        $validator = Validator::make($request->all(), [
            'Tags'=>'required|unique:blog_tags,tag_name',
            'Slug'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'tag_name' => $request->Tags,
                'slug'=>$request->Slug,
                'is_trending'=>$request->IsTrending,
                'status'=>$request->Flag,
                'updated_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => ' Updated successfully',
            'product' => $data
        ], 201);
    }

    public function tagStatus(Request $request,$id)
    {
        $data=BlogTags::find($id);
        $data->update([
            'status'=>$request->Status,
            'is_trending'=>$request->Flag,
            'updated_by' => Auth::user()->id,
        ]);
        return response()->json([
            'message' => ' Updated successfully',
            'product' => $data
        ], 200);
    }

    public function tagList()
    {
        $data=BlogCategory::select('tag_name','slug','is_trending','status')->get();
        return response()->json([
            'list' => $data
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
