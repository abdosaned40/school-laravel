<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStudent extends Model
{
    use HasFactory;
    public $table = 'datastudent';
    public $fillable = [
        'name',
        'email',
        'nim',
        'force',
        'major',
    ];
}
