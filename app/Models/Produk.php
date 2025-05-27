<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(Detail::class);
    }
}
