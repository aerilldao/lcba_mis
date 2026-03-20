<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollmentRecord;

class RecordController extends Controller
{
    public function basicEducationRecords()
    {
        $records = EnrollmentRecord::select('enrollment_records.*')
            ->join('student_info', 'enrollment_records.student_id_no', '=', 'student_info.id_number')
            ->where('enrollment_records.department', 'Basic Education')
            ->orderBy('student_info.last_name', 'asc')
            ->orderBy('student_info.first_name', 'asc')
            ->with('student')
            ->get();
            
        return view('records.basic_education_records', compact('records'));
    }

    public function collegiateRecords()
    {
        $records = EnrollmentRecord::select('enrollment_records.*')
            ->join('student_info', 'enrollment_records.student_id_no', '=', 'student_info.id_number')
            ->where('enrollment_records.department', 'College')
            ->orderBy('student_info.last_name', 'asc')
            ->orderBy('student_info.first_name', 'asc')
            ->with('student')
            ->get();

        return view('records.collegiate_records', compact('records'));
    }
}
