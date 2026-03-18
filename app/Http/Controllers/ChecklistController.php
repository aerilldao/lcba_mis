<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
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
        ]);
    }
}
