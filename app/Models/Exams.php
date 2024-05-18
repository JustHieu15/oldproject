<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'time_limit',
        'number_of_questions',
        'description',
        'subject_id'
    ];
}
