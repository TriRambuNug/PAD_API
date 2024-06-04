<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{
    public function getAllUser(Request $request){
        $user = User::all();

        try{
            return response()->json([
                'success' => true,
                'message' => 'Data User berhasil diambil',
                'data' => $user
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Data User gagal diambil',
                'data' => $user
            ]);
        }
    }

    public function getUserById(Request $request, $id){
        $userId = User::find($id);

        try{
            return response()->json([
                'success'=> true,
                'message'=> 'Data user berhasil diambil',
                'data' => $userId
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success'=> false,
                'message'=> 'Data User tidak ditemukan',
                'data' => $userId
            ]);
        }
    }

    public function updateUser(Request $request, $id){
        Log::info('Update request data: ', $request->all());
        
        $validator = Validator::make($request->all(), [
            'fullname' => 'sometimes|string',
            'phone' => 'sometimes|string|unique:users,phone,'.$id,
            'email' => 'sometimes|string|email|unique:users,email,'.$id,
            'type' => 'sometimes|string',
            'status' => 'sometimes|string',
            'avatar' => 'sometimes|string',
            'pin' => 'sometimes|string',
            'password' => 'sometimes|string|min:6|confirmed',
        ]);
    
        if($validator->fails()){
            Log::warning('Validation failed: ', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }
    
        $user = User::find($id);
    
        if(!$user){
            Log::warning('User not found: ', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'data pengguna tidak ditemukan'
            ], 404);
        }
    
        Log::info('User before update: ', $user->toArray());
    
        $user->update($request->except('id', 'account_code', 'role'));
    
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }
    
        $user->save();
        
        
    
        try{
            Log::info('User after update: ', $user->toArray());
            return response()->json([
                'success' => true,
                'message' => 'data pengguna berhasil diubah',
                'data' => $user
                
            ]);
        }
        catch(\Exception $e){
            Log::error('Error updating user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'data pengguna gagal diubah',
                'data' => $user
            ]);
        }
        
    }

    public function deleteUser(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'data pengguna tidak ditemukan'
            ]);
        }

        try{
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'data pengguna berhasil dihapus'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'data pengguna gagal dihapus'
            ]);
        }
    }

    public function searchUser(Request $request){
        $keyword = $request->input('keyword');
        $user = User::where('fullname', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone', 'like', "%$keyword%")
                    ->get();

        try{
            return response()->json([
                'success' => true,
                'message' => 'Data User berhasil ditemukan',
                'data' => $user
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Data User tidak ditemukan',
                'data' => $user
            ]);
        }
        

    }
}
