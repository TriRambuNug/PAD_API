<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPatner extends Model
{
    use HasFactory;
    protected $table = 'card_patners';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function patner()
    {
        return $this->belongsTo(Patners::class, 'patner_id');
    }



    /**
     * Scope models
     *
     */
}
