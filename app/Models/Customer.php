<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $guarded = [];

    public function faktur()
    {
        return $this->hasMany(Faktur::class);
    }
}
