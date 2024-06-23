<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
