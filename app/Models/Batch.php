<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{

    protected $table="batches";

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
