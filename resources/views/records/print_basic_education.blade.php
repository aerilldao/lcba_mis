<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA Basic Education Form - {{ $record->last_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; }
        body { font-family: 'Roboto', sans-serif; color: #000; line-height: 1.3; margin: 0; padding: 0; background-color: #f0f0f0; font-size: 11px; }
        .print-page { 
            width: 210mm; height: 297mm; padding: 12mm 15mm; margin: 0 auto; background: white; 
            display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; 
        }
        @media print { @page { size: A4; margin: 0; } body { background: none; } .print-page { margin: 0; box-shadow: none; width: 100%; border: none; } .no-print { display: none; } }
        .header-container { display: flex; align-items: start; justify-content: space-between; margin-bottom: 0.75rem; }
        .header-left { display: flex; align-items: center; gap: 1.5rem; flex: 1; }
        .logo { width: 75px; height: auto; }
        .school-info h1 { margin: 0; font-size: 1.8rem; font-weight: 900; }
        .school-info p { margin: 2px 0; font-size: 0.9rem; font-weight: 500; }
        .picture-box { width: 32mm; height: 32mm; border: 1.5px solid #000; display: flex; align-items: center; justify-content: center; text-align: center; font-weight: 700; font-size: 0.8rem; }
        .field-row { display: flex; flex-wrap: nowrap; gap: 0.75rem; margin-bottom: 0.5rem; align-items: flex-end; }
        .label { font-weight: 700; margin-bottom: 2px; font-size: 11px; white-space: nowrap; }
        .value { border-bottom: 1.5px solid #000; min-height: 20px; padding: 1px 6px; font-weight: 500; font-size: 11.5px; }
        .sub-label { font-size: 8.5px; text-align: center; margin-top: 3px; font-weight: 600; text-transform: uppercase; }
        .checkbox-container { display: flex; align-items: center; gap: 0.5rem; font-weight: 600; }
        .checkbox { width: 14px; height: 14px; border: 1.5px solid #000; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 11px; }
        .credential-container { border: 2px solid #000; margin-top: 1rem; padding: 12px; }
        .box-title { text-align: center; font-weight: 900; text-transform: uppercase; border-bottom: 2px solid #000; margin-bottom: 10px; padding-bottom: 5px; font-size: 12px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .cred-item { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 11px; }
        .signatory-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 2rem; text-align: center; }
        .sig-line { border-top: 2px solid #000; padding-top: 5px; font-weight: 800; text-transform: uppercase; font-size: 11px; }
    </style>
</head>
<body>
    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
        <button onclick="window.print()" style="background: #1e3a8a; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">Print Form</button>
    </div>
    <div class="print-page">
        <div class="header-container">
            <div class="header-left">
                <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" class="logo">
                <div class="school-info">
                    <h1>Laguna College of Business and Arts</h1>
                    <p>Basic Education Department — Official Student Record</p>
                    <p>(049) 545-0929 / Calamba City, Laguna</p>
                </div>
            </div>
            <div class="picture-box">2" x 2"<br>Picture</div>
        </div>
        
        <!-- Student Info -->
        <div>
            <div class="field-row">
                <div class="label" style="width: 80px;">Grade Level:</div><div class="value" style="flex: 1;">{{ $record->grade_level }}</div>
                <div class="label" style="width: 60px; margin-left: 20px;">Section:</div><div class="value" style="width: 160px;">{{ $record->section ?: '____' }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 100px;">Student's Name:</div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->last_name }}</div><div class="sub-label">(Last Name)</div></div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->first_name }}</div><div class="sub-label">(First Name)</div></div>
                <div class="field" style="flex: 1;"><div class="value">{{ $record->middle_name ?: '____' }}</div><div class="sub-label">(Middle Name)</div></div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 110px;">LRN:</div><div class="value" style="flex: 1;">{{ $record->lrn ?: '_______________________' }}</div>
                <div class="label" style="width: 100px; margin-left:15px;">Date of Birth:</div><div class="value" style="width: 130px; text-align:center;">{{ $record->birthdate ? date('m / d / y', strtotime($record->birthdate)) : 'MM / DD / YY' }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 110px;">Citizenship:</div><div class="value" style="flex: 1;">{{ $record->citizenship ?? 'Filipino' }}</div>
                <div class="label" style="width: 60px; margin-left:15px;">Gender:</div>
                <div style="display: flex; gap: 1.5rem;"><div class="checkbox-container"><div class="checkbox">{!! strtolower($record->sex) == 'male' ? '&#10003;' : '' !!}</div><span>Male</span></div><div class="checkbox-container"><div class="checkbox">{!! strtolower($record->sex) == 'female' ? '&#10003;' : '' !!}</div><span>Female</span></div></div>
            </div>
            <div class="field-row"><div class="label" style="width: 110px;">Address:</div><div class="value" style="flex: 1;">{{ $record->address }}</div></div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Father's Name:</div><div class="value" style="flex: 1;">{{ $record->father_name }}</div>
                <div class="label" style="width: 130px; margin-left: 15px;">Mother's Name:</div><div class="value" style="flex: 1;">{{ $record->mother_name }}</div>
            </div>
            <div class="field-row">
                <div class="label" style="width: 130px;">Guardian's Name:</div><div class="value" style="flex: 1;">{{ $record->guardian_name }}</div>
                <div class="label" style="width: 70px; margin-left: 15px;">Contact:</div><div class="value" style="width: 160px;">{{ $record->guardian_contact }}</div>
            </div>
        </div>

        <!-- Credentials Section as a dedicated block -->
        <div class="credential-container">
            <div class="box-title">Basic Education Checklist & Credentials</div>
            <div class="grid-2">
                <div>
                    @php $items = ['Form 138 (Report Card)', 'Form 137-A (Permanent Record)', 'PSA Birth Certificate (Photocopy)', 'Certificate of Good Moral']; @endphp
                    @foreach($items as $label)
                        <div class="cred-item"><div class="checkbox">@if(isset($record->credentials) && strpos(json_encode($record->credentials), 'true') !== false) {!! '&#10003;' !!} @endif</div><span>{{ $label }}</span></div>
                    @endforeach
                </div>
                <div>
                    @php $items2 = ['Transfer Credentials', 'ESC Certificate (if applicable)', '2 Picture (2x2)', 'Others (Indicate)']; @endphp
                    @foreach($items2 as $label)
                        <div class="cred-item"><div class="checkbox"></div><span>{{ $label }}</span></div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Signature Section pushed to the bottom -->
        <div>
            <div class="signatory-grid">
                <div class="sig-box"><div class="sig-line">REGISTRAR Representative</div></div>
                <div class="sig-box"><div class="sig-line">GUIDANCE COUNSELOR</div></div>
                <div class="sig-box"><div class="sig-line">DEPARTMENT PRINCIPAL</div></div>
            </div>
            <div style="text-align: center; font-weight: 800; font-size: 11.5px; margin-top: 1.5rem; opacity: 0.9;">
                Laguna College of Business and Arts — Excellence and Innovation
            </div>
            <div style="margin-top: 2rem; border-top: 1px dashed #000; padding-top: 0.75rem; font-size: 9.5px; opacity: 0.7; text-align: center;">
                This record is generated by the LCBA Information System and is intended for official use of the Registrar's Office.
            </div>
        </div>
    </div>
</body>
</html>
