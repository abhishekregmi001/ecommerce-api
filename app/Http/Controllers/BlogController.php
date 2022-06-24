<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogcategory;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class BlogController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blogcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Primary'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->Primary==-1){
            $data=Blogcategory::all();
        }
        else{
            
        }

        return response()->json([
            'message' => ' Added successfully',
            'product' => $data
        ], 200);
    }
    public function updatepostags(Request $request,$id)
    {
        $data=BlogTags::findorfail($id);

        $validator = Validator::make($request->all(), [
            'PostID'=>'required|unique:blog_tags,tag_name',
            'Status'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data->update([
            'post_id' => $request->PostID,
            'tag_id' => $request->TagsID,
            'status'=>$request->status,
            'updated_by' => Auth::user()->id,
            ]);

        return response()->json([
            'message' => ' Updated successfully',
            'product' => $data
        ], 201);
    }

    public function postStatus(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'PostID'=>'required|unique:blog_tags,tag_name',
            'TagsID'=>'required',
            'Flag'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
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
        $data=BlogTags::select('post_id','tag_id','status')->get();
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
