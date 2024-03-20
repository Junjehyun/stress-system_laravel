<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Haisya_mst extends Model
{
    use HasFactory;

    protected $fillable =[
        'KAISYA_CODE',
        'KAISYA_NAME_JPN',
        'KAISYA_NAME_ENG',
    ];
}

