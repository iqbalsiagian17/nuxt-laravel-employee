<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class WorkUnit extends Model
{
    use HasFactory;

    protected $table = 't_work_units';

    protected $fillable = [
        'unit_name',
    ];

    public function employeeDetails()
    {
        return $this->hasMany(EmployeeDetail::class);
    }
}