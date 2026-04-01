<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentRecord;
use App\Models\StudentInfo;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function finishBasicEducation(Request $request)
    {
        $id = $request->input('reg_id');
        $record = EnrollmentRecord::with('student')->findOrFail($id);

        $data = $request->except(['_token', 'reg_id']);

        // Split data between student profile and enrollment record
        $studentFields = ['last_name', 'first_name', 'middle_name', 'date_of_birth', 'sex', 'age', 'father_name', 'mother_name', 'guardian_name', 'guardian_contact', 'address', 'grade_level', 'course', 'major', 'section'];

        // Map form fields to database columns if necessary
        if ($request->has('year_level')) {
            $request->merge(['grade_level' => $request->year_level]);
        }

        $studentData = array_intersect_key($request->all(), array_flip($studentFields));

        if (! empty($studentData) && $record->student) {
            $record->student->update($studentData);
        }

        // Credentials and status logic handled by model's update (stored in extras)
        $data['credentials'] = $request->input('credentials', []);
        $record->update($data);

        return redirect()->route('dashboard')->with('success', 'Registration completed successfully!');
    }

    public function finishCollegiate(Request $request)
    {
        $id = $request->input('reg_id');
        $record = EnrollmentRecord::with('student')->findOrFail($id);

        // Split data similarly for Collegiate
        $studentFields = ['last_name', 'first_name', 'middle_name', 'date_of_birth', 'sex', 'age', 'father_name', 'mother_name', 'guardian_name', 'guardian_contact', 'address', 'grade_level', 'course', 'major', 'section'];

        if ($request->has('year_level')) {
            $request->merge(['grade_level' => $request->year_level]);
        }

        $studentData = array_intersect_key($request->all(), array_flip($studentFields));

        if (! empty($studentData) && $record->student) {
            $record->student->update($studentData);
        }

        // Enrollment Record Details
        $data = $request->except(['_token', 'reg_id', 'last_name', 'first_name', 'middle_name', 'date_of_birth', 'sex', 'age', 'father_name', 'mother_name', 'guardian_name', 'guardian_contact', 'address', 'grade_level', 'course', 'major', 'section']);
        $data['credentials'] = $request->input('credentials', []);

        $record->update($data);

        return redirect()->route('dashboard')->with('success', 'Collegiate registration completed successfully!');
    }

    public function basicEducationForm(Request $request)
    {
        $regId = $request->query('reg_id');
        $record = $regId ? EnrollmentRecord::with('student')->find($regId) : null;

        return view('forms.basic_education', compact('record'));
    }

    public function collegiateForm(Request $request)
    {
        $regId = $request->query('reg_id');
        $record = $regId ? EnrollmentRecord::with('student')->find($regId) : null;

        return view('forms.collegiate', compact('record'));
    }

    /**
     * Look up a student by ID number from the student_info table.
     */
    public function lookupStudent(Request $request)
    {
        $idNumber = $request->query('id_number');

        if (empty($idNumber)) {
            return response()->json(['found' => false, 'message' => 'No ID number provided.'], 400);
        }

        $student = StudentInfo::where('id_number', $idNumber)->first();

        if (! $student) {
            return response()->json(['found' => false, 'message' => 'Student not found.']);
        }

        return response()->json([
            'found' => true,
            'first_name' => $student->first_name ?? '',
            'last_name' => $student->last_name ?? '',
            'middle_name' => $student->middle_name ?? '',
            'date_of_birth' => $student->date_of_birth ?? '',
            'sex' => $student->sex ?? '',
            'age' => $student->age ?? '',
            'father_name' => $student->father_name ?? '',
            'mother_name' => $student->mother_name ?? '',
            'guardian_name' => $student->guardian_name ?? '',
            'guardian_contact' => $student->guardian_contact ?? '',
            'address' => $student->address ?? '',
        ]);
    }

    public function saveChecklist(Request $request)
    {
        $request->validate([
            'id_no' => 'required|string',
            'category' => 'required|in:basic_education,cg_studies',
        ]);

        // 1. Synchronize Source of Truth (student_info)
        $studentData = [
            'id_number' => $request->id_no,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'date_of_birth' => $request->birthdate ?: null,
            'sex' => $request->sex,
            'age' => $request->age ?: null,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'address' => $request->address,
        ];

        StudentInfo::updateOrCreate(
            ['id_number' => $request->id_no],
            $studentData
        );

        // 2. Minimum MIS Record
        $payload = [
            'student_id_no' => $request->id_no,
            'department' => $request->category === 'basic_education' ? 'Basic Education' : 'College',
            'recorded_by' => \Illuminate\Support\Facades\Auth::id(),
        ];

        // Specific enrollment factors
        $extras = [
            'is_balik_aral' => $request->has('is_balik_aral'),
            'is_freshman' => $request->has('is_freshman'),
            'is_transferee' => $request->has('is_transferee'),
        ];

        $payload['extras'] = $extras;

        $record = EnrollmentRecord::updateOrCreate(
            ['student_id_no' => $request->id_no],
            $payload
        );

        \Illuminate\Support\Facades\Log::info("Checklist Saved: Student {$request->id_no}, Record ID {$record->id}");

        return response()->json([
            'status' => 'success',
            'id' => (int) $record->id,
        ]);
    }
}
