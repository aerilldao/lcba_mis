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

    /**
     * Get the dynamic registration status of the student.
     */
    public function getRegistrationStatusAttribute()
    {
        // 1. Critical Info Check (Error if missing)
        // If any core information is not even there, mark as Error.
        $criticalInfo = ['grade_level', 'id_no', 'last_name', 'first_name', 'school_year'];
        foreach ($criticalInfo as $info) {
            if (empty($this->$info)) {
                return (object)[
                    'label' => 'Error',
                    'color' => '#ef4444',
                    'class' => 'error'
                ];
            }
        }

        // 2. Identify Requirements
        $requiredCredentials = [];
        
        // Base Requirement sets
        $freshmanSet = ['f138', 'f137a', 'moral', 'pics', 'psa'];
        $transfereeSet = array_merge($freshmanSet, ['transfer', 'tor']);

        if ($this->is_freshman) {
            $requiredCredentials = array_merge($requiredCredentials, $freshmanSet);
        }
        
        if ($this->is_transferee) {
            $requiredCredentials = array_merge($requiredCredentials, $transfereeSet);
        }

        // If neither Freshman nor Transferee (maybe it's an "Old Student"), 
        // they might not have required credentials for this specific enrollment checklist.
        // However, the user says "selected Freshman", "selected Transferee".
        
        // Credentials check (must be 'true' in the JSON array)
        $hasAllCredentials = true;
        $creds = $this->credentials ?? [];
        foreach ($requiredCredentials as $req) {
            if (!isset($creds[$req]) || $creds[$req] != 'true') {
                $hasAllCredentials = false;
                break;
            }
        }

        // Balik-Aral specific logic
        $hasBalikAralFields = true;
        if ($this->is_balik_aral && ($this->is_freshman || $this->is_transferee)) {
            if (empty($this->last_school_name) || empty($this->last_school_year) || empty($this->school_id)) {
                $hasBalikAralFields = false;
            }
        }

        // 3. Final Decision
        if ($hasAllCredentials && $hasBalikAralFields) {
            return (object)[
                'label' => 'Complete',
                'color' => '#22c55e',
                'class' => 'complete'
            ];
        } else {
            return (object)[
                'label' => 'Pending',
                'color' => '#f59e0b',
                'class' => 'incomplete'
            ];
        }
    }
}
