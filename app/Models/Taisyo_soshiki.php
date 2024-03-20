<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taisyo_soshiki extends Model
{
    use HasFactory;

    protected $fillable = [
        'KAISYA_CODE',
        'SOSHIKI_CODE',
        'KAISYA_NAME_JPN',
        'SOSHIKI_NAME_JPN',
    ];
}
