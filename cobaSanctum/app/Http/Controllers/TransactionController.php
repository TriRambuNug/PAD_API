<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transactions = Transaction::all();
            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil diambil',
                'data' => $transactions
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all transactions: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi gagal diambil',
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
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'required|string|max:191',
            'status' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $transaction = Transaction::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaction
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating transaction: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal dibuat',
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
            $transaction = Transaction::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil diambil',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching transaction by ID: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi gagal diambil',
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
            'user_id' => 'sometimes|exists:users,id',
            'amount' => 'sometimes|numeric',
            'type' => 'sometimes|string|max:191',
            'status' => 'sometimes|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui',
                'data' => $transaction
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating transaction: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal diperbarui',
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
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            Log::error('Error deleting transaction: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal dihapus',
                'data' => null
            ], 500);
        }
    }
}
