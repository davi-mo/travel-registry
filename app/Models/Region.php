<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'active'];

    /**
     * @return string
     */
    public function activeCustomized() : string
    {
        switch ($this->active) {
            case 0:
                return 'No';
            default:
                return 'Yes';
        }
    }
}
