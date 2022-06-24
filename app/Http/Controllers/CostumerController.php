<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Config;
use JWTAuth;


class CostumerController extends Controller
{
  
    public function __construct()
    {
        $this->Costumer = new Costumer;
    }
    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $costumer = Costumer::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

        return response()->json([
            'message' => 'Costuner successfully registered',
            'costumer' => $costumer
        ], 201);
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clogin(Request $request)
    {
        $credentials = $request->all();
		$token = null;
		try {
		    if (!$token = auth('Costumer')->attempt($credentials)) {
		        return response()->json([
		            'response' => 'error',
		            'message' => 'invalid_email_or_password',
		        ]);
		    }
		} catch (JWTAuthException $e) {
		    return response()->json([
		        'response' => 'error',
		        'message' => 'failed_to_create_token',
		    ]);
		}
		return response()->json([
		    'response' => 'success',
		    'result' => [
		        'token' => $token,
		        'message' => 'I am front user',
		    ],
		]);
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clogout()
    {
        auth()->logout();

        return response()->json(['message' => 'costumer successfully logged out.']);
    }
    public function cpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'OldPwd' => 'required',
            'NewPwd' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $validator = Validator::make($request->all(), [
            'OldPwd' => 'current_password:Costumer',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 203);
        }

        $id=Auth::guard('Costumer')->id();
        $data=Costumer::find($id);
        $data->update([
            'password' => Hash::make($request->NewPwd)           
        ]);
        return response()->json([
            'message' => 'Password successfully Changed'
        ], 201);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function crefresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cprofile()
    {
        return response()->json(auth('Costumer')->user());
    }

    public function updateProfile(Request $request,$id)
    {
        $data=Costumer::findOrFail($id);
        $data->update([
            'fullname' => $request->fullname,            
        ]);
        return response()->json([
            'message' => 'Updated Successfully',
            'costumer' => $data
        ], 200);
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