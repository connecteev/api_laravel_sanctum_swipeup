<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    
    /**
     * Get the user that owns the collection.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
