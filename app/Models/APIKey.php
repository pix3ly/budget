<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class APIKey extends Model
{
    protected $table = 'api_keys';

    protected $fillable = [
        'user_id',
        'token'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
