<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'withdrawals';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function pocket()
    {
        return $this->belongsTo(Pocket::class, 'pocket_id');
    }
    
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    
    /**
     * Scope models
     *
     */
}
