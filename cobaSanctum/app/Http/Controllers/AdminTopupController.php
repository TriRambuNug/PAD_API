<?php

namespace App\Http\Controllers;

use App\Models\AdminTopUp;
use App\Models\Pocket;
use App\Models\Transaction;
use App\Models\TransactionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTopupController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'transaction_id' => 'required|exists:transactions,id',
            'pocket_id' => 'required|exists:pockets,id',
            'amount' => 'required|numeric',
            'proff' => 'nullable|string|max:191',
        ]);

        $adminTopup = null;

        DB::transaction(function () use ($validatedData, &$adminTopup) {
            $adminTopup = AdminTopUp::create($validatedData);

            // Update pocket balance
            $pocket = Pocket::find($validatedData['pocket_id']);
            $pocket->balance += $validatedData['amount'];
            $pocket->save();

            // Update transaction gross_amount
            $transaction = Transaction::find($validatedData['transaction_id']);
            $transaction->gross_amount += $validatedData['amount'];
            $transaction->save();

            // Create transaction record
            TransactionRecord::create([
                'user_id' => $validatedData['admin_id'], // Assuming admin ID is used as user ID
                'transaction_id' => $validatedData['transaction_id'],
                'pocket_id' => $validatedData['pocket_id'],
                'amount' => $validatedData['amount'],
                'type' => 'topup',
                'category' => 'topup',
            ]);
        });

        return response()->json($adminTopup, 201);
    }
}
