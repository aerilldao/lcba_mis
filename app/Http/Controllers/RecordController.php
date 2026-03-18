<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BasicEducation;
use App\Models\CgStudy;

class RecordController extends Controller
{
    public function basicEducationRecords()
    {
        $records = BasicEducation::orderBy('last_name', 'asc')->get();
        return view('records.basic_education_records', compact('records'));
    }

    public function collegiateRecords()
    {
        $records = CgStudy::orderBy('last_name', 'asc')->get();
        return view('records.collegiate_records', compact('records'));
    }
}
