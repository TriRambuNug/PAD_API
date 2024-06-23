<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdminTopUp extends Model
{
    use HasFactory;    
    use SoftDeletes;

    protected $table = 'admin_topups';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
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
