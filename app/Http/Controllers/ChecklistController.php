<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BasicEducation;
use App\Models\CgStudy;

class ChecklistController extends Controller
{
    public function finishBasicEducation(Request $request)
    {
        $id = $request->input('reg_id');
        $record = BasicEducation::findOrFail($id);

        $data = $request->except(['_token', 'reg_id']);
        
        // Handle checkbox booleans
        $data['is_balik_aral']  = $request->has('is_balik_aral');
        $data['is_senior_high'] = $request->has('is_senior_high');
        $data['is_freshman']    = $request->has('is_freshman');
        $data['is_transferee']  = $request->has('is_transferee');
        
        $data['credentials']    = $request->input('credentials', []);

        $record->update($data);

        return redirect()->route('dashboard')->with('success', 'Registration completed successfully!');
    }

    public function finishCollegiate(Request $request)
    {
        $id = $request->input('reg_id');
        $record = CgStudy::findOrFail($id);

        $data = $request->except(['_token', 'reg_id']);
        
        // Handle student category dropdown mapping
        $cat = $request->input('student_category');
        $data['is_freshman']       = ($cat === 'freshman');
        $data['is_transferee']     = ($cat === 'transferee');
        $data['is_cross_enrollee'] = ($cat === 'cross_enrollee');
        $data['is_returnee']       = ($cat === 'returnee');

        $data['credentials']    = $request->input('credentials', []);

        $record->update($data);

        return redirect()->route('dashboard')->with('success', 'Collegiate registration completed successfully!');
    }

    public function basicEducationForm(Request $request)
    {
        $regId = $request->query('reg_id');
        $record = $regId ? BasicEducation::find($regId) : null;
        
        return view('forms.basic_education', compact('record'));
    }

    public function collegiateForm(Request $request)
    {
        $regId = $request->query('reg_id');
        $record = $regId ? CgStudy::find($regId) : null;

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

        $student = DB::connection('mysql_lcba')
            ->table('student_info')
            ->where('id_number', $idNumber)
            ->first();

        if (!$student) {
            return response()->json(['found' => false, 'message' => 'Student not found.']);
        }

        /** @var array<string,mixed> $s */
        $s = (array) $student;

        return response()->json([
            'found'         => true,
            'first_name'    => $s['first_name']    ?? '',
            'last_name'     => $s['last_name']     ?? '',
            'middle_name'   => $s['middle_name']   ?? '',
            'date_of_birth' => $s['date_of_birth'] ?? '',
            'sex'           => $s['sex']           ?? '',
            'age'           => $s['age']           ?? '',
            'father_name'   => $s['father_name']   ?? '',
            'mother_name'   => $s['mother_name']   ?? '',
            'guardian_name' => $s['guardian_name'] ?? '',
            'guardian_contact' => $s['guardian_contact'] ?? '',
            'address' => $s['address'] ?? '',
        ]);
    }

    public function saveChecklist(Request $request)
    {
        $request->validate([
            'id_no'    => 'required|string',
            'category' => 'required|in:basic_education,cg_studies',
        ]);

        $payload = [
            'id_no'            => $request->id_no,
            'last_name'        => $request->last_name,
            'first_name'       => $request->first_name,
            'middle_name'      => $request->middle_name,
            'birthdate'        => $request->birthdate ?: null,
            'sex'              => $request->sex,
            'age'              => $request->age ?: null,
            'father_name'      => $request->father_name,
            'mother_name'      => $request->mother_name,
            'guardian_name'    => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'address'          => $request->address,
            'recorded_by'      => \Illuminate\Support\Facades\Auth::id(),
        ];

        if ($request->category === 'basic_education') {
            $record = \App\Models\BasicEducation::updateOrCreate(
                ['id_no' => $request->id_no],
                $payload
            );
        } else {
            $record = \App\Models\CgStudy::updateOrCreate(
                ['id_no' => $request->id_no],
                $payload
            );
        }

        return response()->json([
            'status' => 'success',
            'id' => $record->id
        ]);
    }
}
