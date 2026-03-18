<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Basic Education'])
    <style>
        .checklist-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 1rem 2rem;
            background: var(--header-bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            transition: background-color 0.3s ease;
        }

        .checklist-nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .checklist-nav-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .checklist-nav h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-text-heading);
            letter-spacing: 0.05em;
            margin: 0;
        }

        .sub-navbar {
            background: var(--primary-color);
            width: 100%;
            padding: 0.75rem 2rem;
            color: white;
            position: fixed;
            top: 82px;
            left: 0;
            z-index: 40;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sub-navbar span {
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .checklist-content {
            margin-top: 150px;
            padding: 2rem;
            width: 100%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-left: auto;
            margin-right: auto;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            align-items: flex-start;
        }

        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: opacity 0.35s ease;
            position: relative;
        }

        .section-card.has-open-picker {
            z-index: 100;
        }

        .section-title {
            color: var(--primary-text-heading);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(30, 58, 138, 0.1);
        }

        .field-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1.5rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            flex: 1 1 180px;
        }

        .field.narrow  { flex: 0 1 140px; }
        .field.medium  { flex: 1 1 200px; }
        .field.wide    { flex: 1 1 260px; }
        .field.xwide   { flex: 2 1 300px; }

        .field label {
            font-weight: 600;
            font-size: 0.78rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field input:not([type="checkbox"]),
        .field select {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid var(--card-border);
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s, color 0.3s;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .field input:disabled,
        .field select:disabled {
            background: rgba(0, 0, 0, 0.05);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.7;
        }


        /* Checkbox Group Styles */
        .checkbox-group {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-item span {
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Credentials List Styles */
        .credentials-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .credentials-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .credentials-item:last-child {
            border-bottom: none;
        }

        .credentials-item span {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .credentials-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        @media (max-width: 1200px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .field-row { flex-direction: column; }
            .field, .field.narrow, .field.medium, .field.wide, .field.xwide {
                flex: 1 1 100%;
            }
        }

        /* Custom Datepicker Dropdown */
        .datepicker-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: 10px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.25rem;
            z-index: 1050;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .datepicker-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dp-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .dp-month { font-weight: 800; font-size: 0.85rem; color: #fff; text-transform: uppercase; }
        .dp-nav { display: flex; gap: 0.5rem; }
        .dp-nav-btn { background: rgba(255,255,255,0.05); border: none; color: #fff; width: 28px; height: 28px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
        .dp-nav-btn:hover { background: var(--primary-color); }
        .dp-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .dp-weekday { text-align: center; font-size: 0.65rem; font-weight: 800; color: var(--text-muted); padding: 5px 0; }
        .dp-day { 
            text-align: center; padding: 8px 0; font-size: 0.8rem; font-weight: 700; border-radius: 8px; cursor: pointer; color: var(--text-muted); transition: all 0.2s;
        }
        .dp-day:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .dp-day.current { color: #fff; }
        .dp-day.selected { background: var(--primary-color); color: #fff; }
        .dp-day.today { color: var(--primary-color); position: relative; }
        .dp-day.today::after { content: ''; position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; border-radius: 50%; background: var(--primary-color); }

        .display-field { display: flex; flex-direction: column; gap: 0.25rem; }
        .display-field label { font-size: 0.7rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .display-field span { font-size: 1.05rem; color: var(--primary-text-heading); font-weight: 700; }
        .student-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }

        .credentials-item {
            display: grid;
            grid-template-columns: 1fr 100px;
            align-items: center;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: background 0.3s;
        }
        .credentials-item:hover { background: rgba(0,0,0,0.02); }
        .credentials-status { display: flex; gap: 0.5rem; justify-content: flex-end; }
        .checkbox-custom {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: var(--primary-color);
        }
    </style>
</head>
<body style="align-items: flex-start; background-color: var(--bg-alt); display: block; overflow-y: auto; overflow-x: hidden;">

    <!-- Main Header -->
    @include('partials.navbar-main', [
        'title' => 'BASIC EDUCATION',
        'backRoute' => route('checklist'),
        'backText' => 'Back to Checklist'
    ])

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Basic Education — Student Records</span>
    </div>

    <!-- Main Content -->
    <main class="checklist-content">

        <form action="{{ route('checklist.finish.basic') }}" method="POST">
            @csrf
            <input type="hidden" name="reg_id" value="{{ $record->id ?? '' }}">

            <div class="layout-grid">
                
                <!-- Left Column: Forms -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Student Information (Display Card) -->
                    <div class="section-card" id="section-student" style="background: linear-gradient(145deg, var(--card-bg), rgba(30, 58, 138, 0.03));">
                        <div class="section-title">Student Registration Data</div>
                        
                        @if($record)
                        <div class="student-info-grid">
                            <div class="display-field">
                                <label>Student Name</label>
                                <span>{{ $record->last_name }}, {{ $record->first_name }} {{ $record->middle_name }}</span>
                            </div>
                            <div class="display-field">
                                <label>ID Number</label>
                                <span>{{ $record->id_no }}</span>
                            </div>
                            <div class="display-field">
                                <label>Date of Birth</label>
                                <span>{{ $record->birthdate ? date('F d, Y', strtotime($record->birthdate)) : 'N/A' }}</span>
                            </div>
                            <div class="display-field">
                                <label>Gender</label>
                                <span>{{ $record->sex }}</span>
                            </div>
                            <div class="display-field">
                                <label>Address</label>
                                <span style="font-size: 0.9rem;">{{ $record->address }}</span>
                            </div>
                            <div class="display-field">
                                <label>Guardian</label>
                                <span>{{ $record->guardian_name }} ({{ $record->guardian_contact }})</span>
                            </div>
                        </div>
                        @else
                        <div style="padding: 1rem; text-align: center; color: var(--text-muted); border: 2px dashed rgba(0,0,0,0.1); border-radius: 12px;">
                            No active registration record found. Please return to the checklist menu.
                        </div>
                        @endif
                    </div>

                    <!-- Educational Background & Enrollment Details -->
                    <div class="section-card" id="section-enrollment">
                        <div class="section-title">Educational Background & Enrollment Details</div>
                        
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_balik_aral" id="is_balik_aral" {{ $record && $record->is_balik_aral ? 'checked' : '' }}>
                                <span>Balik Aral</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_senior_high" id="is_senior_high" {{ $record && $record->is_senior_high ? 'checked' : '' }}>
                                <span>Senior High</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_freshman" id="is_freshman" {{ $record && $record->is_freshman ? 'checked' : '' }}>
                                <span>Freshman</span>
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="is_transferee" id="is_transferee" {{ $record && $record->is_transferee ? 'checked' : '' }}>
                                <span>Transferee</span>
                            </label>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label>Grade Level</label>
                                <select name="grade_level">
                                    <option value="" disabled {{ !$record || !$record->grade_level ? 'selected' : '' }}>Select Grade</option>
                                    @foreach(['Kindergarten','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Grade 7','Grade 8','Grade 9','Grade 10','Grade 11','Grade 12'] as $gl)
                                        <option {{ ($record && $record->grade_level == $gl) ? 'selected' : '' }}>{{ $gl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label>School Year</label>
                                <input type="text" name="school_year" placeholder="e.g. 2024–2025" value="{{ $record->school_year ?? '' }}">
                            </div>
                            <div class="field narrow">
                                <label>Section</label>
                                <input type="text" name="section" placeholder="Section" value="{{ $record->section ?? '' }}">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label>LRN (If applicable)</label>
                                <input type="text" name="lrn" placeholder="Enter LRN" value="{{ $record->lrn ?? '' }}">
                            </div>
                            <div class="field">
                                <label>ECS (If applicable)</label>
                                <input type="text" name="ecs" placeholder="Enter ECS" value="{{ $record->ecs ?? '' }}">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label>School last attended</label>
                                <input type="text" name="last_school_name" placeholder="School Name" value="{{ $record->last_school_name ?? '' }}">
                            </div>
                            <div class="field narrow">
                                <label>Last SY</label>
                                <input type="text" name="last_school_year" placeholder="2023-2024" value="{{ $record->last_school_year ?? '' }}">
                            </div>
                            <div class="field narrow">
                                <label>School ID</label>
                                <input type="text" name="school_id" placeholder="School ID" value="{{ $record->school_id ?? '' }}">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field">
                                <label>Strand</label>
                                <input type="text" name="strand" placeholder="Enter Strand" value="{{ $record->strand ?? '' }}">
                            </div>
                            <div class="field">
                                <label>Semester</label>
                                <select name="semester">
                                    <option value="" disabled {{ !$record || !$record->semester ? 'selected' : '' }}>Select Semester</option>
                                    <option {{ ($record && $record->semester == '1st Semester') ? 'selected' : '' }}>1st Semester</option>
                                    <option {{ ($record && $record->semester == '2nd Semester') ? 'selected' : '' }}>2nd Semester</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
                        <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Complete Registration</button>
                    </div>

                </div>

                <!-- Right Column: Credentials -->
                <div class="section-card" id="section-credentials">
                    <div class="section-title">Credentials Check</div>
                    <div class="credentials-list" id="credentials-container">
                        @php
                            $items = [
                                'Form 138' => 'f138',
                                'Form 137-A' => 'f137a',
                                'Good Morale' => 'moral',
                                'Pictures' => 'pics',
                                'PSA (Photocopy)' => 'psa',
                                'Transfer Credentials' => 'transfer',
                                'Transcript of Records' => 'tor'
                            ];
                        @endphp

                        @foreach($items as $label => $key)
                        <div class="credentials-item">
                            <span>{{ $label }}</span>
                            <input type="checkbox" name="credentials[{{ $key }}]" value="true" class="checkbox-custom" {{ ($record && isset($record->credentials[$key]) && $record->credentials[$key] == 'true') ? 'checked' : '' }}>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </form>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ── Dynamic Enrollment Fields Logic ──
            function updateFormStates() {
                const balikAral = document.getElementById('is_balik_aral').checked;
                const seniorHigh = document.getElementById('is_senior_high').checked;
                const freshman = document.getElementById('is_freshman').checked;
                const transferee = document.getElementById('is_transferee').checked;

                let enabledFields = ['grade_level', 'school_year', 'section', 'lrn', 'ecs'];
                let enableAllContent = false;
                let enableAllCredentials = false;

                if (transferee) {
                    enableAllContent = true;
                    enableAllCredentials = true;
                }
                
                if (freshman) {
                    enableAllContent = true;
                }

                if (balikAral) {
                    enabledFields.push('last_school_name', 'last_school_year', 'school_id');
                }

                if (seniorHigh) {
                    enabledFields.push('strand', 'semester');
                }

                const enrollmentCard = document.getElementById('section-enrollment');
                const enrollmentInputs = enrollmentCard.querySelectorAll('input:not([type="checkbox"]), select');

                enrollmentInputs.forEach(input => {
                    if (enableAllContent || enabledFields.includes(input.name)) {
                        input.disabled = false;
                        input.style.opacity = '1';
                    } else {
                        input.disabled = true;
                        input.style.opacity = '0.5';
                        if(input.tagName === 'SELECT') {
                            input.selectedIndex = 0;
                        } else {
                            input.value = '';
                        }
                    }
                });

                // ── Credentials Check Logic ──
                const credentialsCard = document.getElementById('section-credentials');
                const credentialsInputs = credentialsCard.querySelectorAll('input[type="checkbox"]');
                
                const showCredentials = freshman || transferee;
                
                if (showCredentials) {
                    credentialsCard.style.opacity = '1';
                    credentialsCard.style.pointerEvents = 'auto';
                    credentialsInputs.forEach(cb => cb.disabled = false);
                } else {
                    credentialsCard.style.opacity = '0.4';
                    credentialsCard.style.pointerEvents = 'none';
                    credentialsInputs.forEach(cb => {
                        cb.disabled = true;
                        cb.checked = false;
                    });
                }
            }

            // Bind listeners
            const modeCheckboxes = document.querySelectorAll('#section-enrollment .checkbox-group input[type="checkbox"]');
            modeCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateFormStates);
            });

            // Run once on load
            updateFormStates();
        });
    </script>
</body>
</html>
