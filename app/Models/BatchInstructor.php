<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchInstructor extends Model
{
    protected $table='batch_instructors';

    protected $fillable = [
        'batch_id',
        'instructor_id'
    ];
}
