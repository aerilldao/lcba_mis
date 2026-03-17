<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Checklist'])
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

        /* Section card */
        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: opacity 0.35s ease;
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

        /* Horizontal row of fields */
        .field-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }

        /* Individual field */
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

        /* Locked / disabled state */
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

        /* ID hint text */
        .id-hint {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.4rem;
            font-style: italic;
        }

        /* ID card input styling */
        #id_no {
            padding: 0.65rem 1rem;
            border: 1.5px solid rgba(30, 58, 138, 0.3);
            border-radius: 10px;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text-main);
            background: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s;
            min-width: 220px;
        }

        #id_no:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        @media (max-width: 768px) {
            .field-row { flex-direction: column; }
            .field, .field.narrow, .field.medium, .field.wide, .field.xwide {
                flex: 1 1 100%;
            }
        }

        .sub-section {
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(30, 58, 138, 0.1);
        }
        .sub-section:last-child {
            border-bottom: none;
        }
        .section-subtitle {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-text-heading);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
            opacity: 0.8;
        }

        /* Custom Datepicker Dropdown */
        .datepicker-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%; /* Or could change min-width: 250px depending on layout */
            min-width: 280px;
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
        'title' => 'CHECKLIST',
        'backRoute' => route('dashboard'),
        'backText' => 'Back to Dashboard'
    ])

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Basic Information</span>
    </div>

    <!-- Main Content -->
    <main class="checklist-content">

        <!-- BASIC INFORMATION Wrapper -->
        <div class="section-card">
            <div class="section-title">BASIC INFORMATION</div>

            <!-- ID Number Section -->
            <div class="sub-section">
                <div class="section-subtitle">Student ID Lookup</div>
                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                    <div>
                        <label for="id_no" style="display: block; font-weight: 600; font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.35rem;">ID No.</label>
                        <input type="text" id="id_no" name="id_no" placeholder="Enter ID Number" autocomplete="off">
                    </div>
                </div>
                <p class="id-hint" id="id-hint">Enter an ID number to unlock the form fields below.</p>
            </div>

            <!-- Student Information -->
            <div class="sub-section section-locked" id="section-student">
                <div class="section-subtitle">Student Information</div>
                <div class="field-row">
                    <div class="field wide">
                        <label>Last Name</label>
                        <input type="text" name="student_last_name" placeholder="Last Name" disabled>
                    </div>
                    <div class="field wide">
                        <label>First Name</label>
                        <input type="text" name="student_first_name" placeholder="First Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Middle Name</label>
                        <input type="text" name="student_middle_name" placeholder="Middle Name" disabled>
                    </div>
                    <div class="field narrow">
                        <label>Suffix</label>
                        <input type="text" name="student_suffix" placeholder="Jr., III, etc." disabled>
                    </div>
                    <div class="field medium" style="position: relative;">
                        <label>Birthdate</label>
                        <input type="text" id="checklist-input-date" name="student_birthdate" placeholder="YYYY-MM-DD" readonly disabled style="cursor: pointer;">
                        <div class="datepicker-dropdown" id="checklist-datepicker">
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
                        <select name="student_sex" disabled>
                            <option value="" disabled selected>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="field narrow">
                        <label>Age</label>
                        <input type="number" name="student_age" placeholder="Age" disabled>
                    </div>
                </div>
            </div>

            <!-- Father's Information -->
            <div class="sub-section section-locked" id="section-father">
                <div class="section-subtitle">Father's Information</div>
                <div class="field-row">
                    <div class="field wide">
                        <label>Last Name</label>
                        <input type="text" name="father_last_name" placeholder="Last Name" disabled>
                    </div>
                    <div class="field wide">
                        <label>First Name</label>
                        <input type="text" name="father_first_name" placeholder="First Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Middle Name</label>
                        <input type="text" name="father_middle_name" placeholder="Middle Name" disabled>
                    </div>
                    <div class="field narrow">
                        <label>Suffix</label>
                        <input type="text" name="father_suffix" placeholder="Suffix" disabled>
                    </div>
                </div>
            </div>

            <!-- Mother's Information -->
            <div class="sub-section section-locked" id="section-mother">
                <div class="section-subtitle">Mother's Information</div>
                <div class="field-row">
                    <div class="field wide">
                        <label>Last Name</label>
                        <input type="text" name="mother_last_name" placeholder="Last Name" disabled>
                    </div>
                    <div class="field wide">
                        <label>First Name</label>
                        <input type="text" name="mother_first_name" placeholder="First Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Middle Name</label>
                        <input type="text" name="mother_middle_name" placeholder="Middle Name" disabled>
                    </div>
                    <div class="field narrow">
                        <label>Suffix</label>
                        <input type="text" name="mother_suffix" placeholder="Suffix" disabled>
                    </div>
                </div>
            </div>

            <!-- Guardian's Information -->
            <div class="sub-section section-locked" id="section-guardian">
                <div class="section-subtitle">Guardian's Information</div>
                <div class="field-row">
                    <div class="field wide">
                        <label>Last Name</label>
                        <input type="text" name="guardian_last_name" placeholder="Last Name" disabled>
                    </div>
                    <div class="field wide">
                        <label>First Name</label>
                        <input type="text" name="guardian_first_name" placeholder="First Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Middle Name</label>
                        <input type="text" name="guardian_middle_name" placeholder="Middle Name" disabled>
                    </div>
                    <div class="field narrow">
                        <label>Suffix</label>
                        <input type="text" name="guardian_suffix" placeholder="Suffix" disabled>
                    </div>
                    <div class="field medium">
                        <label>Contact Number</label>
                        <input type="text" name="guardian_contact" placeholder="Contact Number" disabled>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="sub-section section-locked" id="section-address">
                <div class="section-subtitle">Address Information</div>
                <div class="field-row">
                    <div class="field narrow">
                        <label>House No.</label>
                        <input type="text" name="house_no" placeholder="House No." disabled>
                    </div>
                    <div class="field medium">
                        <label>Street Name</label>
                        <input type="text" name="street_name" placeholder="Street Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Barangay</label>
                        <input type="text" name="barangay" placeholder="Barangay" disabled>
                    </div>
                    <div class="field narrow">
                        <label>Zip Code</label>
                        <input type="text" name="zip_code" placeholder="Zip Code" disabled>
                    </div>
                    <div class="field xwide">
                        <label>Municipality / City</label>
                        <input type="text" name="municipality_city" placeholder="Municipality / City" disabled>
                    </div>
                    <div class="field medium">
                        <label>Province</label>
                        <input type="text" name="province" placeholder="Province" disabled>
                    </div>
                    <div class="field medium">
                        <label>Country</label>
                        <input type="text" name="country" value="Philippines" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
            <a href="{{ route('basic_education') }}" class="btn-login" style="text-align: center; text-decoration: none; padding: 0.8rem 2rem;">Basic Education</a>
            <a href="{{ route('collegiate') }}" class="btn-login" style="text-align: center; text-decoration: none; padding: 0.8rem 2rem;">Collegiate &amp; Graduate Studies</a>
        </div>

    </main>

    <script>
        const idInput = document.getElementById('id_no');
        const idHint  = document.getElementById('id-hint');
        const sectionIds = [
            'section-student',
            'section-father',
            'section-mother',
            'section-guardian',
            'section-address'
        ];

        function toggleSections(unlock) {
            sectionIds.forEach(function(id) {
                const section = document.getElementById(id);
                if (unlock) {
                    section.classList.remove('section-locked');
                    section.classList.add('section-unlocked');
                    section.querySelectorAll('input, select').forEach(el => el.disabled = false);
                } else {
                    section.classList.remove('section-unlocked');
                    section.classList.add('section-locked');
                    section.querySelectorAll('input, select').forEach(el => el.disabled = true);
                }
            });
            idHint.textContent = unlock
                ? 'ID entered — form fields are now editable.'
                : 'Enter an ID number to unlock the form fields below.';
        }

        idInput.addEventListener('input', function() {
            toggleSections(this.value.trim().length > 0);
        });

        // Datepicker Logic
        const dpMONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        function pad(n) { return n < 10 ? '0' + n : '' + n; }
        function dateKey(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        let dpMonth = new Date().getMonth();
        let dpYear = new Date().getFullYear();
        const dpInput = document.getElementById('checklist-input-date');
        const dpDropdown = document.getElementById('checklist-datepicker');
        const dpMonthLabel = document.getElementById('dp-month-label');
        const dpDaysGrid = document.getElementById('dp-days');
        const dpPrev = document.getElementById('dp-prev');
        const dpNext = document.getElementById('dp-next');

        dpInput.addEventListener('click', (e) => {
            if (dpInput.disabled) return;
            e.stopPropagation();
            dpDropdown.classList.toggle('active');
            if (dpDropdown.classList.contains('active')) {
                if (dpInput.value && dpInput.value.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const d = new Date(dpInput.value + 'T00:00:00');
                    if (!isNaN(d)) {
                        dpMonth = d.getMonth();
                        dpYear = d.getFullYear();
                    }
                } else {
                    dpMonth = new Date().getMonth();
                    dpYear = new Date().getFullYear();
                }
                renderDP();
            }
        });

        document.addEventListener('click', (e) => {
            if (!dpDropdown.contains(e.target) && e.target !== dpInput) {
                dpDropdown.classList.remove('active');
            }
        });

        function renderDP() {
            dpMonthLabel.textContent = `${dpMONTHS[dpMonth]} ${dpYear}`;
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
    </script>

</body>
</html>
