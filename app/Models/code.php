<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class code extends Model
{
    use HasFactory;
    protected $fillable = [
        'codeLog',
        'AppCode',
        'ID_user'
    ];
}
