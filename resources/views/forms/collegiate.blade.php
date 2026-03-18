<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Collegiate & Graduate Studies'])
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
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(30, 58, 138, 0.1);
        }

        .field-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
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

        .field input,
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
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border-color: rgba(0,0,0,0.06);
        }

        .section-locked {
            opacity: 0.4;
            pointer-events: none;
        }

        .section-unlocked {
            opacity: 1;
            pointer-events: auto;
        }

        /* Checkbox Group Styles */
        .credentials-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .credentials-item input[type="text"].inline-input {
            border: none;
            border-bottom: 1px solid var(--text-muted);
            border-radius: 0;
            padding: 0 0.5rem;
            background: transparent;
            font-size: 0.82rem;
            color: var(--text-main);
            width: 150px;
            outline: none;
        }

        .credentials-item input[type="text"].inline-input:focus {
            border-bottom-color: var(--primary-color);
            box-shadow: none;
        }

        .credentials-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
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
        'title' => 'COLLEGIATE & GRADUATE STUDIES',
        'backRoute' => route('checklist'),
        'backText' => 'Back to Checklist'
    ])

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Collegiate &amp; Graduate Studies — Student Records</span>
    </div>    <!-- Main Content -->
    <main class="checklist-content">

        <form action="{{ route('checklist.finish.collegiate') }}" method="POST">
            @csrf
            <input type="hidden" name="reg_id" value="{{ $record->id ?? '' }}">

            <div class="layout-grid">
                
                <!-- Left Column -->
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
                            No active registration record found.
                        </div>
                        @endif
                    </div>

                    <!-- Program & Year Level -->
                    <div class="section-card" id="section-program">
                        <div class="section-title">Program & Year Level</div>

                        <div class="field-row" style="margin-bottom: 1.5rem;">
                            <div class="field wide">
                                <label>Student Category</label>
                                <select name="student_category" id="student_category">
                                    <option value="" disabled {{ !$record || (!$record->is_freshman && !$record->is_transferee) ? 'selected' : '' }}>Select Category</option>
                                    <option value="freshman" {{ $record && $record->is_freshman ? 'selected' : '' }}>Freshman</option>
                                    <option value="transferee" {{ $record && $record->is_transferee ? 'selected' : '' }}>Transferee</option>
                                </select>
                            </div>
                        </div>

                        <div class="field-row" style="margin-bottom: 1.5rem;">
                            <div class="field xwide">
                                <label>Program / Course</label>
                                <input type="text" name="course" placeholder="e.g. BS Computer Science" value="{{ $record->course ?? '' }}">
                            </div>
                            <div class="field wide">
                                <label>Major (If applicable)</label>
                                <input type="text" name="major" placeholder="Major" value="{{ $record->major ?? '' }}">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field wide">
                                <label>Year Level</label>
                                <select name="year_level">
                                    <option value="" disabled {{ !$record || !$record->year_level ? 'selected' : '' }}>Select Year</option>
                                    @foreach(['1st Year','2nd Year','3rd Year','4th Year','5th Year','Graduate / Masteral'] as $yl)
                                        <option {{ ($record && $record->year_level == $yl) ? 'selected' : '' }}>{{ $yl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field medium">
                                <label>School Year</label>
                                <input type="text" name="school_year" placeholder="e.g. 2024–2025" value="{{ $record->school_year ?? '' }}">
                            </div>
                            <div class="field narrow">
                                <label>Semester</label>
                                <select name="semester">
                                    <option value="" disabled {{ !$record || !$record->semester ? 'selected' : '' }}>Select</option>
                                    @foreach(['1st Semester','2nd Semester','Summer'] as $sem)
                                        <option {{ ($record && $record->semester == $sem) ? 'selected' : '' }}>{{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field narrow">
                                <label>Section</label>
                                <input type="text" name="section" placeholder="Section" value="{{ $record->section ?? '' }}">
                            </div>
                        </div>

                        <!-- Student Credentials Section -->
                        <div class="field-row" style="margin-top: 1.5rem;">
                            <div class="field wide">
                                <label>Student Credentials</label>
                                <select name="student_credentials" id="student_credentials">
                                    <option value="" disabled selected>Select Credentials Path</option>
                                    <option value="college_studies">COLLEGE STUDIES</option>
                                    <option value="graduate_studies">GRADUATE STUDIES</option>
                                    <option value="cross_enrollee">CROSS - ENROLLEE</option>
                                </select>
                            </div>
                            <div class="field wide" id="sub_category_wrapper" style="display: none;">
                                <label>Type</label>
                                <select name="student_sub_category" id="student_sub_category">
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="freshman">FOR ENTERING FRESHMAN</option>
                                    <option value="transferee">TRANSFEREE</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
                        <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Complete Registration</button>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div class="section-card" id="section-credentials">
                        <div class="section-title">Credentials Check</div>
                        <div class="credentials-list" id="credentials-container">
                            <!-- Dynamically populated by JavaScript -->
                            <div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; font-style: italic;">
                                Please select a credentials path above to see required items.
                            </div>
                        </div>
                    </div>

                    </div>
                </div>

                </div>

            </div>
        </form>

    </main>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categorySelect     = document.getElementById('student_category');
            const credentialsSelect  = document.getElementById('student_credentials');
            const subCategorySelect  = document.getElementById('student_sub_category');
            const subCategoryWrapper = document.getElementById('sub_category_wrapper');
            const credentialsCard    = document.getElementById('section-credentials');
            const credentialsList    = document.getElementById('credentials-container');

            const credentialSets = {
                'college_studies_freshman': [
                    { label: 'Form 138 (Card)', key: 'f138' },
                    { label: 'Form 137-A (if available)', key: 'f137a' },
                    { label: 'Certificate of Good Moral Character', key: 'moral' },
                    { label: 'Pictures (2x2)', key: 'pics' },
                    { label: 'PSA Birth Certificate (Photocopy)', key: 'psa' },
                    { label: 'PSA Marriage Contract (if married)', key: 'marriage' },
                    { label: 'Others', key: 'others' }
                ],
                'college_studies_transferee': [
                    { label: 'Transfer Credential / Honorable Dismissal', key: 'transfer' },
                    { label: 'Certificate of Good Moral Character', key: 'moral' },
                    { label: 'Pictures (2x2)', key: 'pics' },
                    { label: 'PSA Birth Certificate (Photocopy)', key: 'psa' },
                    { label: 'PSA Marriage Contract (if married)', key: 'marriage' },
                    { label: 'Others', key: 'others' }
                ],
                // Default sets for others if you wish to add them later
                'graduate_studies': [
                    { label: 'Transfer Credentials / Honorable Dismissal', key: 'transfer_honorable' },
                    { label: 'Pictures (2x2)', key: 'pics' },
                    { label: 'PSA Birth Certificate (Photocopy)', key: 'psa' },
                    { label: 'PSA Marriage Contract (if married)', key: 'marriage' },
                    { label: 'Transcript of Records (Copy for LCBA)', key: 'tor_lcba' }
                ],
                'cross_enrollee': [
                    { label: 'Permit to Cross Enroll', key: 'cross_permit' },
                    { label: '1 Picture (2x2)', key: 'pic' },
                    { label: 'School ID (Photocopy)', key: 'school_id' },
                    { label: 'Others', key: 'others' }
                ]
            };

            function renderCredentials(setName) {
                const items = credentialSets[setName];
                if (!items) {
                    credentialsList.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Please select a valid sub-category.</div>';
                    return;
                }

                credentialsList.innerHTML = '';
                items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'credentials-item';
                    div.innerHTML = `
                        <span>${item.label}</span>
                        <input type="checkbox" name="credentials[${item.key}]" value="true" class="checkbox-custom">
                    `;
                    credentialsList.appendChild(div);
                });
            }

            function updateLogic() {
                const credVal = credentialsSelect.value;
                const subVal  = subCategorySelect.value;

                // Show/Hide sub category
                if (credVal === 'college_studies') {
                    subCategoryWrapper.style.display = 'block';
                    if (subVal) {
                        renderCredentials(`college_studies_${subVal}`);
                    } else {
                        credentialsList.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Please select a type (Freshman/Transferee).</div>';
                    }
                } else {
                    subCategoryWrapper.style.display = 'none';
                    if (credVal) {
                        renderCredentials(credVal);
                    } else {
                        credentialsList.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; font-style: italic;">Please select a credentials path above.</div>';
                    }
                }
            }

            credentialsSelect.addEventListener('change', () => {
                subCategorySelect.selectedIndex = 0;
                updateLogic();
            });
            subCategorySelect.addEventListener('change', updateLogic);

            // Basic availability logic (Freshman/Transferee locked/unlocked)
            function updateVisibility() {
                const val = categorySelect.value;
                const isEnabled = (val === 'freshman' || val === 'transferee');
                
                if (isEnabled) {
                    credentialsCard.style.opacity = '1';
                    credentialsCard.style.pointerEvents = 'auto';
                } else {
                    credentialsCard.style.opacity = '0.4';
                    credentialsCard.style.pointerEvents = 'none';
                }
            }

            categorySelect.addEventListener('change', updateVisibility);
            updateVisibility();
        });
    </script>
</body>
</html>
