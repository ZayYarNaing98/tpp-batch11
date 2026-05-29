<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['batch_id', 'image', 'name', 'email', 'phone', 'address', 'enrolled_at', 'status'];

    protected $casts = ['enrolled_at' => 'date'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
