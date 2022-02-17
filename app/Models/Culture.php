<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Culture extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function fertilisers()
    {
        return $this->hasMany(Fertilizer::class, 'culture_id', 'id');
    }
}
