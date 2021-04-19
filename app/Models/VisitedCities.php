<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitedCities extends Model
{
    use HasFactory;

    protected $fillable = ["visited_at"];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return string
     */
    public function formattedVisitedAt() : string
    {
        return $this->visited_at ?
            date_format(\DateTime::createFromFormat('Y-m-d', $this->visited_at), 'd-m-Y') : "";
    }
}
