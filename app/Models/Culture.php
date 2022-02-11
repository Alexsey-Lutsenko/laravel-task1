<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function fertilisers()
    {
        return $this->hasMany(Fertilizer::class, 'culture_id', 'id');
    }
}
