<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PocketPatner extends Model
{
    use HasFactory;
    protected $table = 'pocket_patners';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function pocket()
    {
        return $this->belongsTo(Pocket::class, 'pocket_id');
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
