<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Basic Education'])

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
