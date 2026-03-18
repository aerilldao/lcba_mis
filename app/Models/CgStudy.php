<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CgStudy extends Model
{
    protected $table = 'cg_studies';
    protected $fillable = [
        'id_no', 'last_name', 'first_name', 'middle_name',
        'birthdate', 'sex', 'age',
        'father_name', 'mother_name',
        'guardian_name', 'guardian_contact',
        'address', 'recorded_by',
        'is_freshman', 'is_transferee', 'is_cross_enrollee', 'is_returnee',
        'course', 'major', 'year_level', 'school_year', 'section', 'semester',
        'credentials', 'approvals'
    ];

    protected $casts = [
        'is_freshman' => 'boolean',
        'is_transferee' => 'boolean',
        'is_cross_enrollee' => 'boolean',
        'is_returnee' => 'boolean',
        'credentials' => 'array',
        'approvals' => 'array'
    ];
}
