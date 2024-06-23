<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionRecord extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'transaction_records';
    protected $guarded = [];


    protected $fillable = [
        'user_id', 'transaction_id', 'pocket_id', 'amount', 'type', 'category', 'deleted_at'
    ];
    /**
     * Relation table
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function pocket()
    {
        return $this->belongsTo(Pocket::class, 'pocket_id');
    }

     
    /**
     * Scope models
     *
     */
}
