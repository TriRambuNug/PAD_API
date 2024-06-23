<?php

namespace App\Http\Controllers;

use App\Models\Patners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatnerController extends Controller
{
    public function getAllPatner(Request $request){
        try {
            $patners = Patners::all();

            return response()->json([
                'success' => true,
                'message' => 'Data Patner berhasil diambil',
                'data' => $patners
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all patners: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Patner gagal diambil',
                'data' => []
            ], 500);
        }
    }

    public function getPatnerById(Request $request, $id){
        try {
            $patners = Patners::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Data Patner berhasil diambil',
                'data' => $patners
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error fetching patner by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Patner gagal diambil',
                'data' => null
            ], 500);
        }
    }

    public function updatePatner(Request $request, $id){
        try {
            $patners = Patners::find($id);
            $patners->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data Patner berhasil diupdate',
                'data' => $patners
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error updating patner by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Patner gagal diupdate',
                'data' => null
            ], 500);
        }
    }

    public function deletePatner(Request $request, $id){
        try {
            $patners = Patners::find($id);
            $patners->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Patner berhasil dihapus',
                'data' => $patners
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error deleting patner by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Patner gagal dihapus',
                'data' => null
            ], 500);
        }
    }

    public function createPatner(Request $request){
        try {
            $patners = Patners::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data Patner berhasil dibuat',
                'data' => $patners
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error creating patner: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Patner gagal dibuat',
                'data' => null
            ], 500);
        }
    }
}
