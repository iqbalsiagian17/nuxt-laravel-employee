<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmployeeDetail extends Model
{
    use HasFactory;

    protected $table = 't_employee_details';

    protected $fillable = [
        'employee_id',
        'position_id',
        'work_unit_id',
        'phone_number',
        'tax_number',
        'rank',
        'echelon',
        'workplace',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }
}