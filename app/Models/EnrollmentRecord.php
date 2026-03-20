<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EnrollmentRecord extends Model
{
    public $incrementing = true;
    protected $keyType = 'int';

    protected static function boot()
    {
        parent::boot();

        // Automatically update the static enrollment_status column 
        // to match the dynamic registration_status logic on every save
        static::saving(function ($record) {
            $statusObj = $record->registration_status;
            if ($statusObj && isset($statusObj->label)) {
                $record->enrollment_status = $statusObj->label;
            }
        });
    }

    protected $table = 'enrollment_records';

    protected $fillable = [
        'student_id_no', 'department', 
        'school_year', 'semester', 'enrollment_status', 'extras', 'recorded_by'
    ];

    protected $casts = [
        'extras' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(StudentInfo::class, 'student_id_no', 'id_number');
    }

    // --- Student Profile Delegation (Delegate to StudentInfo) ---
    // This ensures that $record->last_name pulls from $record->student->last_name

    public function getLastNameAttribute() { return $this->student->last_name ?? ($this->attributes['last_name'] ?? ''); }
    public function getFirstNameAttribute() { return $this->student->first_name ?? ($this->attributes['first_name'] ?? ''); }
    public function getMiddleNameAttribute() { return $this->student->middle_name ?? ($this->attributes['middle_name'] ?? ''); }
    public function getBirthdateAttribute() { return $this->student->date_of_birth ?? ($this->extras['birthdate'] ?? null); }
    public function getSexAttribute() { return $this->student->sex ?? ($this->extras['sex'] ?? ''); }
    public function getAgeAttribute() { return $this->student->age ?? ($this->extras['age'] ?? null); }
    public function getFatherNameAttribute() { return $this->student->father_name ?? ($this->extras['father_name'] ?? ''); }
    public function getMotherNameAttribute() { return $this->student->mother_name ?? ($this->extras['mother_name'] ?? ''); }
    public function getGuardianNameAttribute() { return $this->student->guardian_name ?? ($this->extras['guardian_name'] ?? ''); }
    public function getGuardianContactAttribute() { return $this->student->guardian_contact ?? ($this->extras['guardian_contact'] ?? ''); }
    public function getAddressAttribute() { return $this->student->address ?? ($this->extras['address'] ?? ''); }

    // --- Enrollment Compatibility ---

    public function getIdNoAttribute() { return $this->student_id_no; }
    public function setIdNoAttribute($value) { $this->attributes['student_id_no'] = $value; }

    public function getYearLevelAttribute() { return $this->student->grade_level ?? ($this->attributes['grade_level'] ?? ''); }
    public function setYearLevelAttribute($value) { /* Handled in controller */ }

    public function getGradeLevelAttribute() { return $this->student->grade_level ?? ($this->attributes['grade_level'] ?? ''); }
    public function setGradeLevelAttribute($value) { /* Handled in controller */ }

    public function getCourseAttribute() { return $this->student->course ?? ($this->attributes['strand_course'] ?? ''); }
    public function setCourseAttribute($value) { /* Handled in controller */ }

    public function getMajorAttribute() { return $this->student->major ?? ($this->attributes['major'] ?? ''); }
    public function setMajorAttribute($value) { /* Handled in controller */ }

    public function getStrandAttribute() { return $this->student->strand ?? ($this->attributes['strand_course'] ?? ''); }

    /**
     * Magic getter to prioritize extras for MIS-specific fields.
     */
    public function __get($key)
    {
        $extraKeys = [
            'credentials', 'is_balik_aral', 'is_senior_high', 'is_freshman', 'is_transferee', 
            'is_cross_enrollee', 'is_returnee', 'lrn', 'ecs', 'approvals',
            'student_category', 'student_sub_category', 'student_credentials',
            'last_school_name', 'last_school_year', 'school_id', 'strand', 'section'
        ];

        if (in_array($key, $extraKeys)) {
            $extras = $this->extras ?? [];
            return $extras[$key] ?? null;
        }

        return parent::__get($key);
    }

    public function __set($key, $value)
    {
        $extraKeys = [
            'credentials', 'is_balik_aral', 'is_senior_high', 'is_freshman', 'is_transferee', 
            'is_cross_enrollee', 'is_returnee', 'lrn', 'ecs', 'approvals',
            'student_category', 'student_sub_category', 'student_credentials',
            'last_school_name', 'last_school_year', 'school_id', 'strand', 'section'
        ];

        if (in_array($key, $extraKeys)) {
            $extras = $this->extras ?? [];
            $extras[$key] = $value;
            $this->extras = $extras;
            return;
        }

        parent::__set($key, $value);
    }

    public function __isset($key)
    {
        $extraKeys = [
            'credentials', 'is_balik_aral', 'is_senior_high', 'is_freshman', 'is_transferee', 
            'is_cross_enrollee', 'is_returnee', 'lrn', 'ecs', 'approvals',
            'student_category', 'student_sub_category', 'student_credentials',
            'last_school_name', 'last_school_year', 'school_id', 'strand', 'section'
        ];

        if (in_array($key, $extraKeys)) {
            $extras = $this->extras ?? [];
            return isset($extras[$key]);
        }

        return parent::__isset($key);
    }

    /**
     * Override update to handle both main table columns and the extras JSON blob.
     * Also respects mutators.
     */
    public function update(array $attributes = [], array $options = [])
    {
        $mainFields = $this->fillable;
        $extras = $this->extras ?? [];
        
        // We also want to allow fields that have explicit setAttribute methods (mutators)
        // or identified as personal information that should be ignored by the enrollment record update
        // (as they are usually handled by updating the student model directly)
        $studentFields = [
            'last_name', 'first_name', 'middle_name', 'date_of_birth', 'sex', 'age', 
            'father_name', 'mother_name', 'guardian_name', 'guardian_contact', 'address'
        ];

        foreach ($attributes as $key => $value) {
            // If it's a student field, we skip it here (it's handled in the controller)
            if (in_array($key, $studentFields)) {
                unset($attributes[$key]);
                continue;
            }

            // check if there's a mutator for this key
            $method = 'set' . \Illuminate\Support\Str::studly($key) . 'Attribute';
            if (method_exists($this, $method)) {
                continue; // Let the model handle it normally via fill() in parent::update
            }

            // If it's not a main field and not a standard model field, put it in extras
            if (!in_array($key, $mainFields) && !in_array($key, ['id', 'created_at', 'updated_at', 'recorded_by'])) {
                $extras[$key] = $value;
                unset($attributes[$key]);
            }
        }
        
        $attributes['extras'] = $extras;
        return parent::update($attributes, $options);
    }

    // --- Registration Status Logic ---

    public function getRegistrationStatusAttribute()
    {
        if (!$this->student) {
            return (object)['label' => 'No Student', 'color' => '#ef4444', 'class' => 'error'];
        }

        // Status is error if explicitly set
        if ($this->enrollment_status === 'Error') {
            return (object)['label' => 'Error Found', 'color' => '#ef4444', 'class' => 'error'];
        }

        // Standardize credentials array
        $rawCreds = $this->credentials;
        $creds = is_array($rawCreds) ? $rawCreds : [];
        
        // --- Logic for Basic Education ---
        if ($this->department === 'Basic Education') {
            $isBalikAral = ($this->is_balik_aral == 'on' || $this->is_balik_aral === true || $this->is_balik_aral == 1);
            $isFreshman  = ($this->is_freshman == 'on' || $this->is_freshman === true || $this->is_freshman == 1 || 
                             $this->is_senior_high == 'on' || $this->is_senior_high === true || $this->is_senior_high == 1);
            $isTransferee = ($this->is_transferee == 'on' || $this->is_transferee === true || $this->is_transferee == 1);

            // 1. Balik Aral Logic (Most restrictive)
            if ($isBalikAral) {
                $required = ['f138', 'f137a', 'moral', 'pics', 'psa', 'transfer', 'tor'];
                $allDocs = true;
                foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allDocs = false; break; } }
                
                // Check required input fields for Balik Aral
                $inputsComplete = !empty($this->last_school_name) && !empty($this->last_school_year) && !empty($this->school_id);
                
                if ($allDocs && $inputsComplete) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
                return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
            }

            // 2. Transferee Logic
            if ($isTransferee) {
                $required = ['f138', 'f137a', 'moral', 'pics', 'psa', 'transfer', 'tor'];
                $allDocs = true;
                foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allDocs = false; break; } }
                
                if ($allDocs) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
                return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
            }

            // 3. Freshman / Senior High Logic
            if ($isFreshman) {
                $required = ['f138', 'f137a', 'moral', 'pics', 'psa'];
                $allDocs = true;
                foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allDocs = false; break; } }
                
                if ($allDocs) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
                return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
            }
        }

        // --- Logic for College ---
        // Identify Category (be very robust, check multiple potential locations)
        $category = $this->student_category ?: $this->student_sub_category;
        
        $isFreshmanCollege = ($category === 'freshman' || $this->is_freshman == 'on' || $this->is_freshman === true);
        $isTransfereeCollege = ($category === 'transferee' || $this->is_transferee == 'on' || $this->is_transferee === true);
        $isGraduate = ($this->student_credentials === 'graduate_studies' || $this->is_graduate_studies === 'on');

        if ($isFreshmanCollege) {
            // Required for freshman: Form 138, Good Moral, Pictures, PSA
            $required = ['f138', 'moral', 'pics', 'psa'];
            $allPresent = true;
            foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allPresent = false; break; } }
            
            if ($allPresent) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
            return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
        }

        if ($isTransfereeCollege) {
            // Required for transferee: Transfer Credential, Good Moral, Pictures, PSA
            $required = ['transfer', 'moral', 'pics', 'psa'];
            $allPresent = true;
            foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allPresent = false; break; } }
            
            if ($allPresent) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
            return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
        }

        if ($isGraduate) {
            // Required for graduate: TOR, Pictures
            $required = ['tor', 'pics'];
            $allPresent = true;
            foreach ($required as $doc) { if (!array_key_exists($doc, $creds)) { $allPresent = false; break; } }
            
            if ($allPresent) return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
            return (object)['label' => 'Incomplete', 'color' => '#f59e0b', 'class' => 'incomplete'];
        }

        // Fallback or explicit status
        if ($this->enrollment_status === 'Complete') {
            return (object)['label' => 'Complete', 'color' => '#22c55e', 'class' => 'complete'];
        }

        return (object)['label' => 'Pending', 'color' => '#3b82f6', 'class' => 'incomplete'];
    }
}
