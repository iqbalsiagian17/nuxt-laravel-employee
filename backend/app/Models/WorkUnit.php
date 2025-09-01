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
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(WorkUnit::class, 'parent_id');
    }

    /**
     * Relasi ke children (anak-anak)
     */
    public function children()
    {
        return $this->hasMany(WorkUnit::class, 'parent_id');
    }

    public function employeeDetails()
    {
        return $this->hasMany(EmployeeDetail::class);
    }
}