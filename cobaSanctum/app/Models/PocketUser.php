<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PocketUser extends Model
{
    use HasFactory;
    protected $table = 'pocket_users';
    protected $guarded = [];

    /**
     * Relation table
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
