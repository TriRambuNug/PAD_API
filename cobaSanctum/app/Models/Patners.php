<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patners extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'patners';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function cardPatner()
    {
        return $this->hasMany(CardPatner::class, 'patner_id');
    }

    public function member()
    {
        return $this->hasMany(Member::class, 'patner_id');
    }

    public function pocketPatner()
    {
        return $this->hasMany(PocketPatner::class, 'patner_id');
    }

     
    /**
     * Scope models
     *
     */
}
