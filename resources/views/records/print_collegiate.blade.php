<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA Registrar Form - {{ $record->last_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; }
        body { font-family: 'Roboto', sans-serif; color: #000; line-height: 1.25; margin: 0; padding: 0; background-color: #f0f0f0; font-size: 11px; }
        .print-page { 
            width: 210mm; 
            height: 297mm; 
            padding: 10mm 15mm; 
            margin: 0 auto; 
            background: white; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            overflow: hidden; 
        }
        @media print { @page { size: A4; margin: 0; } body { background: none; } .print-page { margin: 0; box-shadow: none; width: 100%; border: none; } .no-print { display: none; } }
        .header-container { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; }
        .header-left { display: flex; align-items: center; gap: 1.5rem; flex: 1; }
        .logo { width: 75px; height: auto; }
        .school-info h1 { margin: 0; font-size: 1.8rem; font-weight: 900; letter-spacing: -0.01em; }
        .school-info p { margin: 1px 0; font-size: 0.9rem; font-weight: 500; }
        .picture-box { width: 32mm; height: 32mm; border: 1.5px solid #000; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; font-weight: 700; font-size: 0.8rem; }
        .field-row { display: flex; flex-wrap: nowrap; gap: 0.75rem; margin-bottom: 0.4rem; align-items: flex-end; }
        .label { font-weight: 700; font-size: 10.5px; white-space: nowrap; margin-bottom: 2px; }
        .value { border-bottom: 1.5px solid #000; min-height: 18px; padding: 1px 6px; font-weight: 500; font-size: 11px; }
        .sub-label { font-size: 8.5px; text-align: center; font-weight: 600; text-transform: uppercase; margin-top: 2px; }
        .checkbox-container { display: flex; align-items: center; gap: 0.5rem; font-weight: 600; white-space: nowrap; }
        .checkbox { width: 14px; height: 14px; border: 1.5px solid #000; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 11px; }
        .credential-container { display: grid; grid-template-columns: 1fr 1fr; border: 2px solid #000; margin-top: 0.75rem; }
        .credential-box { padding: 8px 10px; border: 0.5px solid #000; }
        .box-title { text-align: center; font-weight: 900; text-transform: uppercase; border-bottom: 1.5px solid #000; margin-bottom: 6px; padding-bottom: 4px; font-size: 11px; }
        .cred-item { display: flex; align-items: center; gap: 6px; margin-bottom: 3px; font-size: 10px; }
        .signatory-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; text-align: center; margin-top: 1rem; }
        .sig-box { padding-top: 1.5rem; }
        .sig-line { border-top: 1.5px solid #000; padding-top: 4px; font-weight: 800; text-transform: uppercase; font-size: 10.5px; }
        .sig-label { font-size: 9px; font-weight: 600; }
        .edu-table { width: 100%; border-collapse: collapse; border: 2px solid #000; margin-top: 0.5rem; }
        .edu-table td { border: 1px solid #000; padding: 4px 8px; height: 26px; font-size: 10.5px; }
    </style>
</head>
<body>
    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
        <button onclick="window.print()" style="background: #1e3a8a; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">Print Record</button>
    </div>
    <div class="print-page">
        <!-- Part 1: Header -->
        <div class="header-container">
            <div class="header-left">
                <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" class="logo">
                <div class="school-info">
                    <h1>Laguna College of Business and Arts</h1>
                    <p>P. Burgos St., Calamba City, Laguna</p>
                    <p>(049) 545-0929 / registrarIcba@gmail.com</p>
                </div>
            </div>
            <div class="picture-box">2" x 2"<br>Picture</div>
        </div>

        <!-- Part 2: Main Fields -->
        <div>
            <div class="field-row">
                <div class="label" style="width: 70px;">Program:</div>
                <div class="value" style="flex: 1;">{{ $record->strand ?: ($record->course ?: '_______________________') }}</div>
                <div class="checkbox-container"><div class="checkbox">{!! $record->is_freshman ? '&#10003;' : '' !!}</div><span>Freshman</span></div>
                <div class="checkbox-container"><div class="checkbox">{!! $record->is_transferee ? '&#10003;' : '' !!}</div><span>Transferee</span></div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 100px;">Student's Name:</div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->last_name }}</div><div class="sub-label">(Last Name)</div></div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->first_name }}</div><div class="sub-label">(First Name)</div></div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->middle_name ?: '____' }}</div><div class="sub-label">(Middle Name)</div></div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 100px;">Date of Birth:</div>
                <div class="field" style="width: 130px;"><div class="value" style="text-align: center;">{{ $record->birthdate ? date('m / d / y', strtotime($record->birthdate)) : 'MM / DD / YY' }}</div></div>
                <div class="label" style="width: 90px; margin-left:10px;">Place of Birth:</div>
                <div class="value" style="flex: 1;">{{ $record->place_of_birth }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 100px;">Citizenship:</div><div class="value" style="flex: 1;">{{ $record->citizenship ?? 'Filipino' }}</div>
                <div class="label" style="width: 50px; margin-left:10px;">Gender:</div>
                <div class="checkbox-container"><div class="checkbox">{!! strtolower($record->sex) == 'male' ? '&#10003;' : '' !!}</div><span>Male</span></div>
                <div class="checkbox-container"><div class="checkbox">{!! strtolower($record->sex) == 'female' ? '&#10003;' : '' !!}</div><span>Female</span></div>
                <div class="label" style="width: 40px; margin-left:10px;">Age:</div><div class="value" style="width: 50px; text-align:center;">{{ $record->age }}</div>
            </div>
            <div class="field-row"><div class="label" style="width: 100px;">Civil Status:</div><div class="value" style="flex: 1;">{{ $record->civil_status ?? 'Single' }}</div></div>
            <div class="field-row"><div class="label" style="width: 100px;">Home Address:</div><div class="value" style="flex: 1;">{{ $record->address }}</div></div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Father's Name:</div><div class="value" style="flex: 1;">{{ $record->father_name }}</div>
                <div class="label" style="width: 70px; margin-left:10px;">Occupation:</div><div class="value" style="width: 180px;">{{ $record->father_occupation }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Mother's Maiden Name:</div><div class="value" style="flex: 1;">{{ $record->mother_name }}</div>
                <div class="label" style="width: 70px; margin-left:10px;">Occupation:</div><div class="value" style="width: 180px;">{{ $record->mother_occupation }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Guardian's Name:</div><div class="value" style="flex: 1;">{{ $record->guardian_name }}</div>
                <div class="label" style="width: 70px; margin-left:10px;">Contact No:</div><div class="value" style="width: 180px;">{{ $record->guardian_contact }}</div>
            </div>
            <div class="field-row"><div class="label" style="width: 130px;">Guardian's Address:</div><div class="value" style="flex: 1;">{{ $record->guardian_address }}</div></div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Student's Contact No:</div><div class="value" style="flex: 1;">{{ $record->contact_number }}</div>
                <div class="label" style="width: 60px; margin-left:10px;">Email:</div><div class="value" style="width: 180px;">{{ $record->email ?: '____' }}</div>
            </div>
        </div>

        <!-- Part 3: Education Table -->
        <table class="edu-table">
            <thead style="font-weight: 800; background-color:#f5f5f5;">
                <tr><td style="width: 45%;">School Last Attended:</td><td style="text-align:center;">Address</td><td style="width: 120px; text-align:center;">Year Graduated</td></tr>
            </thead>
            <tbody>
                <tr><td>Elementary: {{ $record->elementary_school }}</td><td>{{ $record->elementary_address }}</td><td style="text-align:center;">{{ $record->elementary_year }}</td></tr>
                <tr><td>Junior High School: {{ $record->last_school_name }}</td><td>{{ $record->last_school_address }}</td><td style="text-align:center;">{{ $record->last_school_year }}</td></tr>
                <tr><td>Senior High School: {{ $record->shs_school }}</td><td>{{ $record->shs_address }}</td><td style="text-align:center;">{{ $record->shs_year }}</td></tr>
            </tbody>
        </table>

        <!-- Part 4: Credentials -->
        <div class="credential-container">
            <div class="credential-box">
                <div class="box-title">COLLEGE STUDIES - FRESHMAN</div>
                @php $items = ['Form 138 (Card)', 'Form 137-A (if available)', 'Cert of Good Moral Character', 'Pictures (2x2)', 'PSA Birth Certificate (Photocopy)', 'PSA Marriage Contract (if married)']; $keys = ['f138', 'f137a', 'moral', 'pics', 'psa', 'marriage']; @endphp
                @foreach($items as $i => $label)
                    <div class="cred-item"><div class="checkbox">{!! ($record->is_freshman && isset($record->credentials[$keys[$i]]) && $record->credentials[$keys[$i]] == 'true') ? '&#10003;' : '' !!}</div><span>{{ $label }}</span></div>
                @endforeach
            </div>
            <div class="credential-box">
                <div class="box-title">TRANSFEREE</div>
                @php $items = ['Transfer Credential', 'Cert of Good Moral Character', 'Pictures (2x2)', 'PSA Birth Certificate (Photocopy)', 'PSA Marriage Contract (if married)', 'Others']; $keys = ['transfer', 'moral', 'pics', 'psa', 'marriage', 'others']; @endphp
                @foreach($items as $i => $label)
                    <div class="cred-item"><div class="checkbox">{!! ($record->is_transferee && isset($record->credentials[$keys[$i]]) && $record->credentials[$keys[$i]] == 'true') ? '&#10003;' : '' !!}</div><span>{{ $label }}</span></div>
                @endforeach
            </div>
            <div class="credential-box">
                <div class="box-title">GRADUATE STUDIES</div>
                @php $items = ['Transfer Credentials', 'PSA Birth Certificate (Photocopy)', 'PSA Marriage Contract (if married)', 'Transcript of Records']; $keys = ['transfer', 'psa', 'marriage', 'tor']; @endphp
                @foreach($items as $i => $label)
                    <div class="cred-item"><div class="checkbox">{!! (isset($record->credentials['student_credentials']) && $record->credentials['student_credentials'] == 'graduate_studies' && isset($record->credentials[$keys[$i]]) && $record->credentials[$keys[$i]] == 'true') ? '&#10003;' : '' !!}</div><span>{{ $label }}</span></div>
                @endforeach
            </div>
            <div class="credential-box">
                <div class="box-title">CROSS-ENROLLEE / UNIT EARNER</div>
                <div class="cred-item" style="margin-top: 5px;"><div class="checkbox"></div><span>Permit to Cross Enroll</span></div>
                <div class="cred-item"><div class="checkbox"></div><span>1 Picture (2x2)</span></div>
                <div class="cred-item"><div class="checkbox"></div><span>Transcript of Records (Photocopy)</span></div>
            </div>
        </div>

        <!-- Part 5: Signatories & Footer -->
        <div>
            <div class="signatory-grid">
                <div class="sig-box"><div class="sig-line">REGISTRAR Representative</div></div>
                <div class="sig-box"><div class="sig-line">GUIDANCE COUNSELOR</div><div class="sig-label">(Assessment/Interview)</div></div>
                <div class="sig-box"><div class="sig-line">DEAN/PROGRAM CHAIR</div><div class="sig-label">(Approval)</div></div>
            </div>
            <div style="text-align: center; font-weight: 800; font-size: 11px; margin-top: 1rem;">
                NOTE: SUBMIT THE ORIGINAL COPY PLUS 3 PHOTOCOPIES OF ALL CREDENTIALS
            </div>
            <div style="margin-top: 0.5rem; font-size: 8.5px; opacity: 0.9;">
                * In filling up this form, you are not yet enrolling. You are just getting the approval of the admission officer.<br>
                * This form should be returned to the registrar (encoding of subjects)
            </div>
            <div class="field-row" style="margin-top: 1.25rem;">
                <div class="field" style="flex: 2;"><div class="value" style="border-bottom: 2px solid #000;"></div><div class="sub-label">Signature over printed name</div></div>
                <div class="field" style="flex: 1;"><div class="value" style="text-align: center; border-bottom: 2px solid #000;">{{ date('m / d / y') }}</div><div class="sub-label">Date: MM / DD / YY</div></div>
            </div>
            <div style="margin-top: 0.8rem; font-size: 9px; text-align: justify; line-height: 1.4;">
                <b>Privacy Statement</b>: By signing, I agree to the LCBA privacy policy. The LCBA Privacy policy explains how to use, process, share, retain and dispose personal data, and how one can exercise property rights.
            </div>
        </div>
    </div>
</body>
</html>
