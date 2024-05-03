<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'employee';
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];


    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
    // public function softDeleteEmployees()
    // {
    //     $this->employees()->update(['deleted_at' => now()]);
    // }
}
