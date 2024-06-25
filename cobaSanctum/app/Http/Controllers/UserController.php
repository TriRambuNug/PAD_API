<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getAllUser(Request $request)
    {
        try {
            $users = User::all();

            return response()->json([
                'success' => true,
                'message' => 'Data User berhasil diambil',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all users: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data User gagal diambil',
                'data' => []
            ], 500);
        }
    }

    public function getUserById(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data User tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diambil',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching user by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data User gagal diambil',
                'data' => null
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        Log::info('Update request data: ', $request->all());

        $validator = Validator::make($request->all(), [
            'fullname' => 'sometimes|string',
            'phone' => 'sometimes|string|unique:users,phone,' . $id,
            'email' => 'sometimes|string|email|unique:users,email,' . $id,
            'type' => 'sometimes|string',
            'status' => 'sometimes|string',
            'avatar' => 'sometimes|string',
            'pin' => 'sometimes|string',
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed: ', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $user = User::find($id);

            if (!$user) {
                Log::warning('User not found: ', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan'
                ], 404);
            }

            Log::info('User before update: ', $user->toArray());

            $user->update($request->except('id', 'account_code', 'role'));

            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            Log::info('User after update: ', $user->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diubah',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna gagal diubah',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna gagal dihapus',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function searchUser(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $users = User::where('fullname', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%")
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data User berhasil ditemukan',
                'data' => $users
            ]);
        } catch (\Exception $e) {
            Log::error('Error searching for users: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data User tidak ditemukan',
                'data' => []
            ], 500);
        }
    }

    public function changePassword(Request $request, $id)
    {
        // Logging request data for debugging
        Log::info('Password change request data: ', $request->all());
    
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            Log::warning('Validation failed: ', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }
    
        try {
            // Find the user by ID
            $user = User::find($id);
    
            if (!$user) {
                Log::warning('User not found: ', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengguna tidak ditemukan'
                ], 404);
            }
    
            // Check if current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                Log::warning('Current password does not match: ', ['id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi saat ini tidak cocok'
                ], 400);
            }
    
            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            Log::info('User password updated: ', ['id' => $id]);
    
            return response()->json([
                'success' => true,
                'message' => 'Kata sandi berhasil diubah',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error changing password: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi gagal diubah',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    
}
