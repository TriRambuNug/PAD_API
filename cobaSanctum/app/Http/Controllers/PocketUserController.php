<?php

namespace App\Http\Controllers;

use App\Models\PocketUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PocketUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pocketUsers = PocketUser::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Pocket User berhasil diambil',
                'data' => $pocketUsers
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all pocket users: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Pocket User gagal diambil',
                'data' => []
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pocket_id' => 'required|exists:pockets,id',
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pocketUser = PocketUser::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pocket User berhasil dibuat',
                'data' => $pocketUser
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating pocket user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket User gagal dibuat',
                'data' => []
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $pocketUser = PocketUser::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data Pocket User berhasil diambil',
                'data' => $pocketUser
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching pocket user by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Pocket User gagal diambil',
                'data' => null
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Tidak diperlukan untuk API
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pocket_id' => 'sometimes|exists:pockets,id',
            'user_id' => 'sometimes|exists:users,id',
            'balance' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pocketUser = PocketUser::findOrFail($id);
            $pocketUser->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pocket User berhasil diperbarui',
                'data' => $pocketUser
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating pocket user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket User gagal diperbarui',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pocketUser = PocketUser::findOrFail($id);
            $pocketUser->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pocket User berhasil dihapus',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            Log::error('Error deleting pocket user: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket User gagal dihapus',
                'data' => null
            ], 500);
        }
    }
}
