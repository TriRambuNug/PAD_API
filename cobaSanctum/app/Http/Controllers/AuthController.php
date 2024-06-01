<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //register function
    public function register(Request $request){
         //set validation
         $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'fullname' => 'required|string',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'account_code' => uniqid(),
            'email' => $request->email,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    //login function
    public function login(Request $request){
        //set validation
        $validator = Validator::make($request->all(), [
            'phone'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('phone', 'password');

        //if auth failed
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Phone atau Password Anda salah'
            ], 401);
        }

        //if auth success
        $dataUser = User::where('phone', $request->phone)->first();
        return response()->json([
            'success' => true,
            'user'    => $dataUser,
            'token'   => $dataUser->createToken('user_token')->plainTextToken
        ], 200);  
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'massage' => 'Logout Berhasil'
        ]);
    }

    public function me(Request $request){
        try{
            return response()->json([
                'success' => true,
                'user'    => $request->user()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
