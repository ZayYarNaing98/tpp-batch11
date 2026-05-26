<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = ['name', 'email', 'phone'];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
