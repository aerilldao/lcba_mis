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

        <div class="layout-grid">
            
            <!-- Left Column: Forms -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Student Information -->
                <div class="section-card" id="section-student">
                    <div class="section-title">Student Information</div>
                    <div class="field-row">
                        <div class="field wide">
                            <label>Last Name</label>
                            <input type="text" name="student_last_name" placeholder="Last Name">
                        </div>
                        <div class="field wide">
                            <label>First Name</label>
                            <input type="text" name="student_first_name" placeholder="First Name">
                        </div>
                        <div class="field medium">
                            <label>Middle Name</label>
                            <input type="text" name="student_middle_name" placeholder="Middle Name">
                        </div>
                        <div class="field narrow">
                            <label>Suffix</label>
                            <input type="text" name="student_suffix" placeholder="Jr., III, etc.">
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field medium" style="position: relative;">
                            <label>Birthdate</label>
                            <input type="text" name="student_birthdate" id="input-birthdate" placeholder="Select birthdate" readonly style="cursor: pointer;">
                            <div class="datepicker-dropdown" id="birthdate-datepicker">
                                <div class="dp-header">
                                    <div class="dp-month" id="dp-month-label">March 2026</div>
                                    <div class="dp-nav">
                                        <button type="button" class="dp-nav-btn" id="dp-prev">←</button>
                                        <button type="button" class="dp-nav-btn" id="dp-next">→</button>
                                    </div>
                                </div>
                                <div class="dp-grid">
                                    <div class="dp-weekday">Su</div>
                                    <div class="dp-weekday">Mo</div>
                                    <div class="dp-weekday">Tu</div>
                                    <div class="dp-weekday">We</div>
                                    <div class="dp-weekday">Th</div>
                                    <div class="dp-weekday">Fr</div>
                                    <div class="dp-weekday">Sa</div>
                                </div>
                                <div class="dp-grid" id="dp-days"></div>
                            </div>
                        </div>
                        <div class="field narrow">
                            <label>Sex</label>
                            <select name="student_sex">
                                <option value="" disabled selected>Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="field narrow">
                            <label>Age</label>
                            <input type="number" name="student_age" placeholder="Age">
                        </div>
                    </div>
                </div>

                <!-- Educational Background & Enrollment Details -->
                <div class="section-card" id="section-enrollment">
                    <div class="section-title">Educational Background & Enrollment Details</div>
                    
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="balik_aral">
                            <span>Balik Aral</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="senior_high">
                            <span>Senior High</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="freshman">
                            <span>Freshman</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="transferee">
                            <span>Transferee</span>
                        </label>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>Grade Level</label>
                            <select name="grade_level">
                                <option value="" disabled selected>Select Grade</option>
                                <option>Kindergarten</option>
                                <option>Grade 1</option>
                                <option>Grade 2</option>
                                <option>Grade 3</option>
                                <option>Grade 4</option>
                                <option>Grade 5</option>
                                <option>Grade 6</option>
                                <option>Grade 7</option>
                                <option>Grade 8</option>
                                <option>Grade 9</option>
                                <option>Grade 10</option>
                                <option>Grade 11</option>
                                <option>Grade 12</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>School Year</label>
                            <input type="text" name="school_year" placeholder="e.g. 2024–2025">
                        </div>
                        <div class="field narrow">
                            <label>Section</label>
                            <input type="text" name="section" placeholder="Section">
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>LRN (If applicable)</label>
                            <input type="text" name="lrn" placeholder="Enter LRN">
                        </div>
                        <div class="field">
                            <label>ECS (If applicable)</label>
                            <input type="text" name="ecs" placeholder="Enter ECS">
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>School last attended</label>
                            <input type="text" name="last_school_name" placeholder="School Name">
                        </div>
                        <div class="field narrow">
                            <label>Last SY</label>
                            <input type="text" name="last_school_year" placeholder="2023-2024">
                        </div>
                        <div class="field narrow">
                            <label>School ID</label>
                            <input type="text" name="school_id" placeholder="School ID">
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>Strand</label>
                            <input type="text" name="strand" placeholder="Enter Strand">
                        </div>
                        <div class="field">
                            <label>Semester</label>
                            <select name="semester">
                                <option value="" disabled selected>Select Semester</option>
                                <option>1st Semester</option>
                                <option>2nd Semester</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
                    <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Save Information</button>
                </div>

            </div>

            <!-- Right Column: Credentials -->
            <div class="section-card">
                <div class="section-title">Credentials Check</div>
                <div class="credentials-list">
                    <div class="credentials-item">
                        <span>Form 138</span>
                        <input type="checkbox" name="credential_138">
                    </div>
                    <div class="credentials-item">
                        <span>Form 137-A</span>
                        <input type="checkbox" name="credential_137a">
                    </div>
                    <div class="credentials-item">
                        <span>Good Morale</span>
                        <input type="checkbox" name="credential_moral">
                    </div>
                    <div class="credentials-item">
                        <span>Pictures</span>
                        <input type="checkbox" name="credential_pics">
                    </div>
                    <div class="credentials-item">
                        <span>PSA (Photocopy)</span>
                        <input type="checkbox" name="credential_psa">
                    </div>
                    <div class="credentials-item">
                        <span>Transfer Credentials</span>
                        <input type="checkbox" name="credential_transfer">
                    </div>
                    <div class="credentials-item">
                        <span>Transcript of Records</span>
                        <input type="checkbox" name="credential_tor">
                    </div>
                </div>
            </div>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const pad = (n) => n < 10 ? '0' + n : n;
            const dateKey = (y, m, d) => `${y}-${pad(m + 1)}-${pad(d)}`;

            // ── Custom Datepicker Logic ──
            let dpMonth = new Date().getMonth();
            let dpYear = new Date().getFullYear();
            const dpInput = document.getElementById('input-birthdate');
            const dpDropdown = document.getElementById('birthdate-datepicker');
            const dpMonthLabel = document.getElementById('dp-month-label');
            const dpDaysGrid = document.getElementById('dp-days');
            const dpPrev = document.getElementById('dp-prev');
            const dpNext = document.getElementById('dp-next');

            dpInput.addEventListener('click', (e) => {
                e.stopPropagation();
                const isActive = dpDropdown.classList.toggle('active');
                
                // Raise the card z-index
                const parentCard = dpInput.closest('.section-card');
                if (isActive) {
                    parentCard.classList.add('has-open-picker');
                } else {
                    parentCard.classList.remove('has-open-picker');
                }

                if (dpDropdown.classList.contains('active')) {
                    if (dpInput.value) {
                        const d = new Date(dpInput.value + 'T00:00:00');
                        if (!isNaN(d)) {
                            dpMonth = d.getMonth();
                            dpYear = d.getFullYear();
                        }
                    }
                    renderDP();
                }
            });

            document.addEventListener('click', (e) => {
                if (!dpDropdown.contains(e.target) && e.target !== dpInput) {
                    dpDropdown.classList.remove('active');
                    const parentCard = dpInput.closest('.section-card');
                    if (parentCard) parentCard.classList.remove('has-open-picker');
                }
            });

            function renderDP() {
                dpMonthLabel.textContent = `${MONTHS[dpMonth]} ${dpYear}`;
                dpDaysGrid.innerHTML = '';

                const firstDay = new Date(dpYear, dpMonth, 1).getDay();
                const daysInMonth = new Date(dpYear, dpMonth + 1, 0).getDate();
                const today = new Date();
                const selectedStr = dpInput.value;

                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    dpDaysGrid.appendChild(empty);
                }

                for (let d = 1; d <= daysInMonth; d++) {
                    const dayEl = document.createElement('div');
                    dayEl.className = 'dp-day current';
                    dayEl.textContent = d;

                    const dayKeyStr = dateKey(dpYear, dpMonth, d);
                    if (dayKeyStr === selectedStr) dayEl.classList.add('selected');
                    if (dayKeyStr === dateKey(today.getFullYear(), today.getMonth(), today.getDate())) dayEl.classList.add('today');

                    dayEl.addEventListener('click', () => {
                        dpInput.value = dayKeyStr;
                        dpDropdown.classList.remove('active');
                        dpInput.closest('.section-card').classList.remove('has-open-picker');
                    });

                    dpDaysGrid.appendChild(dayEl);
                }
            }

            dpPrev.addEventListener('click', (e) => {
                e.stopPropagation();
                dpMonth--;
                if (dpMonth < 0) { dpMonth = 11; dpYear--; }
                renderDP();
            });

            dpNext.addEventListener('click', (e) => {
                e.stopPropagation();
                dpMonth++;
                if (dpMonth > 11) { dpMonth = 0; dpYear++; }
                renderDP();
            });

            // ── Dynamic Enrollment Fields Logic ──
            function updateFormStates() {
                const balikAral = document.querySelector('input[name="balik_aral"]').checked;
                const seniorHigh = document.querySelector('input[name="senior_high"]').checked;
                const freshman = document.querySelector('input[name="freshman"]').checked;
                const transferee = document.querySelector('input[name="transferee"]').checked;

                let enabledFields = ['grade_level', 'lrn', 'ecs'];
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
                    enabledFields.push('last_school_name', 'school_id');
                }

                if (seniorHigh) {
                    enabledFields.push('strand', 'semester');
                }

                const enrollmentCard = document.getElementById('section-enrollment');
                const enrollmentInputs = enrollmentCard.querySelectorAll('input:not([type="checkbox"]), select');

                enrollmentInputs.forEach(input => {
                    if (enableAllContent || enabledFields.includes(input.name)) {
                        input.disabled = false;
                    } else {
                        input.disabled = true;
                        // Clear out values on disable
                        if(input.tagName === 'SELECT') {
                            input.selectedIndex = 0;
                        } else {
                            input.value = '';
                        }
                    }
                });

                const credentialsInputs = document.querySelectorAll('.credentials-list input[type="checkbox"]');
                credentialsInputs.forEach(input => {
                    if (enableAllCredentials) {
                        input.disabled = false;
                        input.closest('.credentials-item').style.opacity = '1';
                    } else {
                        input.disabled = true;
                        input.checked = false;
                        input.closest('.credentials-item').style.opacity = '0.5';
                    }
                });
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
