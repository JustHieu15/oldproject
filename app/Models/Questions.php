<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'exam_id'
    ];
}
