<?php

namespace App\Http\Controllers;

use App\Models\Pocket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PocketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pockets = Pocket::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Pocket berhasil diambil',
                'data' => $pockets
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all pockets: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Pocket gagal diambil',
                'data' => []
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pocket_code' => 'required|unique:pockets,pocket_code|max:191',
            'name' => 'required|max:191',
            'picture' => 'required|max:191',
            'balance' => 'required|numeric',
            'limit' => 'required|numeric',
            'target' => 'required|numeric',
            'ishide' => 'required|boolean',
            'color' => 'nullable|max:191',
            'status' => 'required|max:191',
            'type' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pocket = Pocket::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pocket berhasil dibuat',
                'data' => $pocket
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating pocket: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket gagal dibuat',
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
            $pocket = Pocket::find($id);
            if (!$pocket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pocket tidak ditemukan',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data Pocket berhasil diambil',
                'data' => $pocket
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching pocket by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Pocket gagal diambil',
                'data' => null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pocket_code' => 'required|max:191|unique:pockets,pocket_code,' . $id,
            'name' => 'required|max:191',
            'picture' => 'required|max:191',
            'balance' => 'required|numeric',
            'limit' => 'required|numeric',
            'target' => 'required|numeric',
            'ishide' => 'required|boolean',
            'color' => 'nullable|max:191',
            'status' => 'required|max:191',
            'type' => 'required|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pocket = Pocket::find($id);
            if (!$pocket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pocket tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $pocket->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pocket berhasil diperbarui',
                'data' => $pocket
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating pocket: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket gagal diperbarui',
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
            $pocket = Pocket::find($id);
            if (!$pocket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pocket tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $pocket->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pocket berhasil dihapus',
                'data' => $pocket
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting pocket by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Pocket gagal dihapus',
                'data' => null
            ], 500);
        }
    }
}
