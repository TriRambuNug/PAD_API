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
            'admin_id' => 'required|exists:users,id',
            'transaction_id' => 'required|exists:transactions,id',
            'pocket_id' => 'required|exists:pockets,id',
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

            // Mengambil dan mengupdate gross_amount Transaction
            $transaction = Transaction::find($validatedData['transaction_id']);
            if ($transaction) {
                $transaction->gross_amount += $validatedData['amount'];
                $transaction->save();
            } else {
                Log::error('Transaction not found');
                throw new \Exception('Transaction not found');
            }

            // Membuat catatan transaksi baru (TransactionRecord)
            TransactionRecord::create([
                'user_id' => $validatedData['admin_id'], // Asumsi ID admin digunakan sebagai ID user
                'transaction_id' => $validatedData['transaction_id'],
                'pocket_id' => $validatedData['pocket_id'],
                'amount' => $validatedData['amount'],
                'type' => 'topup',
                'category' => 'topup',
            ]);
        });

        // Memberikan respons dengan data adminTopup dan kode status 201 (Created)
        return response()->json($adminTopup, 201);
    }
}
