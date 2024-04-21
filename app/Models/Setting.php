<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_db_name',
        'logo_path',
        'company_name',
        'logo_donem_no',
        'logo_firma_no'
    ];
}
