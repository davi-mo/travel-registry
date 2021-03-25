<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleAccount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
