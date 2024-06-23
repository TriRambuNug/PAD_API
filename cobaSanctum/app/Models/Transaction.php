<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'transactions';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function adminTopUp()
    {
        return $this->hasMany(AdminTopUp::class, 'transaction_id');
    }

    public function transactionRecord()
    {
        return $this->hasMany(TransactionRecord::class, 'transaction_id');
    }

    public function transactionTopUp()
    {
        return $this->hasOne(TransactionTopUp::class, 'transaction_id');
    }

    public function withdrawal()
    {
        return $this->hasMany(Withdrawal::class, 'transaction_id');
    }

     
    /**
     * Scope models
     *
     */
}
