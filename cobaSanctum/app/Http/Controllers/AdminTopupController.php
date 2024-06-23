<?php

namespace App\Http\Controllers;

use App\Models\AdminTopUp;
use App\Models\Pocket;
use App\Models\Transaction;
use App\Models\TransactionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminTopupController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data dari request
        $validatedData = $request->validate([
            'admin_id' => 'required',
            'transaction_id' => 'required',
            'pocket_id' => 'required',
            'amount' => 'required|numeric',
            'proff' => 'nullable|string|max:191',
        ]);

        $adminTopup = null;

        DB::transaction(function () use ($validatedData, &$adminTopup) {
            // Membuat entri AdminTopUp baru
            $adminTopup = AdminTopUp::create($validatedData);

            // Mengambil dan mengupdate saldo Pocket
            $pocket = Pocket::find($validatedData['pocket_id']);
            if ($pocket) {
                Log::info('Pocket balance before topup: ' . $pocket->balance);
                $pocket->balance += $validatedData['amount'];
                $pocket->save();
            } else {
                Log::error('Pocket not found');
                throw new \Exception('Pocket not found');
            }

           
            // Membuat catatan transaksi baru (TransactionRecord)
            TransactionRecord::create([
                'user_id' => $validatedData['admin_id'], 
                'transaction_id' => $validatedData['transaction_id'],
                'pocket_id' => $validatedData['pocket_id'],
                'amount' => $validatedData['amount'],
                'type' => 'topup',
                'category' => 'topup',
            ]);
        });

        // Memberikan respons dengan data adminTopup dan kode status 201 (Created)
        return response()->json($adminTopup, 201);

        $db = DB::connection()->getPdo();
        dd($db);
    }

    public function index()
    {
       try{
            $adminTopup = AdminTopUp::all();
            return response()->json([
                'success' => true,
                'message' => 'Data Topup berhasil diambil',
                'data' => $adminTopup
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching all topup: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Data Topup gagal diambil',
                'data' => []
            ], 500);
        
       }
    }
}


