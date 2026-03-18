<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasicEducation extends Model
{
    protected $table = 'basic_education';
    protected $fillable = [
        'id_no', 'last_name', 'first_name', 'middle_name',
        'birthdate', 'sex', 'age',
        'father_name', 'mother_name',
        'guardian_name', 'guardian_contact',
        'address', 'recorded_by',
        'is_balik_aral', 'is_senior_high', 'is_freshman', 'is_transferee',
        'grade_level', 'school_year', 'section', 'lrn', 'ecs',
        'last_school_name', 'last_school_year', 'school_id', 'strand', 'semester',
        'credentials',
    ];

    protected $casts = [
        'credentials' => 'array',
        'is_balik_aral' => 'boolean',
        'is_senior_high' => 'boolean',
        'is_freshman' => 'boolean',
        'is_transferee' => 'boolean',
    ];
}
