<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pocket extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'pockets';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function adminTopUp()
    {
        return $this->hasMany(AdminTopUp::class, 'pocket_id');
    }

    public function card()
    {
        return $this->hasMany(Card::class, 'pocket_id');
    }

    public function pocketPatner()
    {
        return $this->hasMany(PocketPatner::class, 'pocket_id');
    }

    public function pocketUser()
    {
        return $this->hasMany(PocketUser::class, 'pocket_id');
    }

    public function transactionRecord()
    {
        return $this->hasMany(TransactionRecord::class, 'pocket_id');
    }

    public function withdrawal()
    {
        return $this->hasMany(Withdrawal::class, 'pocket_id');
    }

     
    /**
     * Scope models
     *
     */
}
