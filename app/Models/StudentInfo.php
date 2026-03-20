<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = 'student_info';
    protected $guarded = []; // Allow mass assignment for all as requested for syncing
}
