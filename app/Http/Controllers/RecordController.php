<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollmentRecord;

class RecordController extends Controller
{
    public function basicEducationRecords(Request $request)
    {
        $records = EnrollmentRecord::select('enrollment_records.*')
            ->join('student_info', 'enrollment_records.student_id_no', '=', 'student_info.id_number')
            ->where('enrollment_records.department', 'Basic Education')
            ->when($request->grade, function ($query, $grade) {
                return $query->where('student_info.grade_level', $grade);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('enrollment_records.enrollment_status', $status);
            })
            ->orderBy('student_info.last_name', $request->sort === 'desc' ? 'desc' : 'asc')
            ->orderBy('student_info.first_name', $request->sort === 'desc' ? 'desc' : 'asc')
            ->with('student')
            ->get();
            
        return view('records.basic_education_records', compact('records'));
    }

    public function collegiateRecords(Request $request)
    {
        $records = EnrollmentRecord::select('enrollment_records.*')
            ->join('student_info', 'enrollment_records.student_id_no', '=', 'student_info.id_number')
            ->whereIn('enrollment_records.department', ['College', 'Graduate'])
            ->when($request->program, function ($query, $program) {
                return $query->where('student_info.course', $program);
            })
            ->when($request->year, function ($query, $year) {
                return $query->where('student_info.grade_level', $year);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('enrollment_records.enrollment_status', $status);
            })
            ->orderBy('student_info.last_name', $request->sort === 'desc' ? 'desc' : 'asc')
            ->orderBy('student_info.first_name', $request->sort === 'desc' ? 'desc' : 'asc')
            ->with('student')
            ->get();

        return view('records.collegiate_records', compact('records'));
    }



    public function printBasicEducation($id)
    {
        $record = EnrollmentRecord::with('student')->findOrFail($id);
        return view('records.print_basic_education', compact('record')); // This will be the new view
    }

    public function printCollegiate($id)
    {
        $record = EnrollmentRecord::with('student')->findOrFail($id);
        return view('records.print_collegiate', compact('record')); // This is the one from the photo
    }
}
