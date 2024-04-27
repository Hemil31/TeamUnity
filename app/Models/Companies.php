<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    public $table = 'companies';
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

}
