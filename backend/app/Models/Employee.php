<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    use HasFactory;

    protected $table = 't_employees';

    protected $fillable = [
        'employee_number',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'photo',
        'religion_id',
    ];

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function employeeDetails()
    {
        return $this->hasOne(EmployeeDetail::class);
    }
}