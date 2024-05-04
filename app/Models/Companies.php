<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'companies';
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }


}
