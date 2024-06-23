<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTopUp extends Model
{
    use HasFactory;
    protected $table = 'transaction_topups';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
     
    /**
     * Scope models
     *
     */
}
