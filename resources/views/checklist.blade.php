<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LCBA - Checklist</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dark-mode.js') }}"></script>
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
            color: var(--primary-color);
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
            color: var(--primary-color);
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
            color: var(--primary-color);
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
        .dp-month-container { display: flex; align-items: center; gap: 0.5rem; }
        .dp-month { font-weight: 800; font-size: 0.85rem; color: #fff; text-transform: uppercase; }
        .dp-year-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid transparent;
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            border-radius: 6px;
            padding: 4px 10px;
            cursor: pointer;
            outline: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        .dp-year-btn:hover {
            background: rgba(255,255,255,0.15);
        }
        .dp-years-view {
            display: none;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
            max-height: 220px;
            overflow-y: auto;
            padding-right: 4px;
        }
        .dp-years-view.active {
            display: grid;
        }
        .dp-year-item {
            text-align: center;
            padding: 10px 0;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
        }
        .dp-year-item:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .dp-year-item.selected { background: var(--primary-color); color: #fff; }
        
        .dp-years-view::-webkit-scrollbar { width: 4px; }
        .dp-years-view::-webkit-scrollbar-track { background: transparent; }
        .dp-years-view::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        .dp-years-view::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }

        .dp-calendar-view { display: block; }
        .dp-calendar-view.hidden { display: none; }
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
    <nav class="checklist-nav">
        <div class="checklist-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="checklist-nav-logo">
            <h1>CHECKLIST</h1>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('dashboard') }}" class="btn-back" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
            </form>
        </div>
    </nav>

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

            <div class="sub-section section-locked" id="section-student">
                <div class="section-subtitle">Student Information</div>
                <div class="field-row">
                    <div class="field wide">
                        <label>Last Name</label>
                        <input type="text" id="student_last_name" name="student_last_name" placeholder="Last Name" disabled>
                    </div>
                    <div class="field wide">
                        <label>First Name</label>
                        <input type="text" id="student_first_name" name="student_first_name" placeholder="First Name" disabled>
                    </div>
                    <div class="field medium">
                        <label>Middle Name</label>
                        <input type="text" id="student_middle_name" name="student_middle_name" placeholder="Middle Name" disabled>
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
                                <div class="dp-month-container">
                                    <div class="dp-month" id="dp-month-label">March</div>
                                    <button type="button" id="dp-year-btn" class="dp-year-btn">2026</button>
                                </div>
                                <div class="dp-nav" id="dp-nav">
                                    <button type="button" class="dp-nav-btn" id="dp-prev">←</button>
                                    <button type="button" class="dp-nav-btn" id="dp-next">→</button>
                                </div>
                            </div>
                            <div id="dp-calendar-view" class="dp-calendar-view">
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
                            <div id="dp-years-view" class="dp-years-view"></div>
                        </div>
                    </div>
                    <div class="field narrow">
                        <label>Sex</label>
                        <select id="student_sex" name="student_sex" disabled>
                            <option value="" disabled selected>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="field narrow">
                        <label>Age</label>
                        <input type="number" id="student_age" name="student_age" placeholder="Age" disabled>
                    </div>
                </div>
            </div>

            <!-- Father's Information -->
            <div class="sub-section section-locked" id="section-father">
                <div class="section-subtitle">Father's Information</div>
                <div class="field-row">
                    <div class="field xwide">
                        <label>Full Name (Last Name, First Name, Middle Name, Suffix)</label>
                        <input type="text" id="father_full_name" name="father_full_name" placeholder="e.g. Dela Cruz, Juan Santos Jr." disabled>
                    </div>
                </div>
            </div>

            <!-- Mother's Information -->
            <div class="sub-section section-locked" id="section-mother">
                <div class="section-subtitle">Mother's Information</div>
                <div class="field-row">
                    <div class="field xwide">
                        <label>Full Name (Last Name, First Name, Middle Name, Suffix)</label>
                        <input type="text" id="mother_full_name" name="mother_full_name" placeholder="e.g. Dela Cruz, Maria Santos" disabled>
                    </div>
                </div>
            </div>

            <!-- Guardian's Information -->
            <div class="sub-section section-locked" id="section-guardian">
                <div class="section-subtitle">Guardian's Information</div>
                <div class="field-row">
                    <div class="field xwide">
                        <label>Full Name (Last Name, First Name, Middle Name, Suffix)</label>
                        <input type="text" id="guardian_full_name" name="guardian_full_name" placeholder="e.g. Dela Cruz, Pedro Santos" disabled>
                    </div>
                    <div class="field medium">
                        <label>Contact Number</label>
                        <input type="text" id="guardian_contact" name="guardian_contact" placeholder="Contact Number" disabled>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="sub-section section-locked" id="section-address">
                <div class="section-subtitle">Address Information</div>
                <div class="field-row">
                    <div class="field xwide">
                        <label>Full Address (House No., Street, Barangay, City, Province, Zip)</label>
                        <input type="text" id="student_address" name="student_address" placeholder="e.g. 123 Main St, Brgy. Central, Manila, Metro Manila, 1000" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
            <a href="{{ route('basic_education') }}" id="btn-basic-ed" class="btn-login" style="text-align: center; text-decoration: none; padding: 0.8rem 2rem;">Basic Education</a>
            <a href="{{ route('collegiate') }}" id="btn-collegiate" class="btn-login" style="text-align: center; text-decoration: none; padding: 0.8rem 2rem;">Collegiate &amp; Graduate Studies</a>
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

        let idLookupTimer = null;
        const LOOKUP_URL = '{{ route("checklist.lookup") }}';

        function setHint(msg, color) {
            idHint.textContent = msg;
            idHint.style.color = color || '';
        }

        function clearStudentFields() {
            document.getElementById('student_last_name').value  = '';
            document.getElementById('student_first_name').value = '';
            document.getElementById('student_middle_name').value = '';
            document.getElementById('checklist-input-date').value = '';
            document.getElementById('student_sex').value = '';
            document.getElementById('student_age').value = '';
            document.getElementById('father_full_name').value = '';
            document.getElementById('mother_full_name').value = '';
            document.getElementById('guardian_full_name').value = '';
            document.getElementById('guardian_contact').value = '';
            document.getElementById('student_address').value = '';
        }

        function populateStudentFields(data) {
            document.getElementById('student_last_name').value   = data.last_name   || '';
            document.getElementById('student_first_name').value  = data.first_name  || '';
            document.getElementById('student_middle_name').value = data.middle_name || '';
            document.getElementById('checklist-input-date').value = data.date_of_birth || '';

            const sexSelect = document.getElementById('student_sex');
            const sexVal = (data.sex || '').trim();
            // Try to match Male / Female case-insensitively
            for (let i = 0; i < sexSelect.options.length; i++) {
                if (sexSelect.options[i].value.toLowerCase() === sexVal.toLowerCase()) {
                    sexSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('student_age').value = data.age || '';
            document.getElementById('father_full_name').value = data.father_name || '';
            document.getElementById('mother_full_name').value = data.mother_name || '';
            document.getElementById('guardian_full_name').value = data.guardian_name || '';
            document.getElementById('guardian_contact').value = data.guardian_contact || '';
            document.getElementById('student_address').value = data.address || '';
        }

        idInput.addEventListener('input', function() {
            const val = this.value.trim();

            // Always clear timer on new keystroke
            clearTimeout(idLookupTimer);

            if (val.length === 0) {
                toggleSections(false);
                clearStudentFields();
                setHint('Enter an ID number to unlock the form fields below.');
                return;
            }

            // Unlock UI immediately so user can see the form
            toggleSections(true);
            setHint('Looking up student…', 'var(--text-muted)');

            // Debounce: wait 400ms after user stops typing before fetching
            idLookupTimer = setTimeout(async () => {
                try {
                    const response = await fetch(`${LOOKUP_URL}?id_number=${encodeURIComponent(val)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.found) {
                        populateStudentFields(data);
                        setHint('✓ Student found — fields populated. You may still edit them.', 'green');
                    } else {
                        clearStudentFields();
                        setHint('No student found with this ID. You may fill in the form manually.', 'orange');
                    }
                } catch (err) {
                    setHint('Lookup failed. Please check your connection.', 'red');
                }
            }, 400);
        });

        // ── Save-then-redirect logic ──────────────────────────────────────────
        const btnBasicEd   = document.getElementById('btn-basic-ed');
        const btnCollegiate = document.getElementById('btn-collegiate');

        async function saveAndRedirect(e, el, category) {
            e.preventDefault();
            const idVal = (idInput.value || '').trim();
            const target = el.href;

            if (idVal.length > 0) {
                const origText = el.innerText;
                el.innerText = 'Saving…';
                el.style.pointerEvents = 'none';

                try {
                    const response = await fetch('{{ route("checklist.save") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            id_no:             idVal,
                            last_name:         document.getElementById('student_last_name')?.value   || '',
                            first_name:        document.getElementById('student_first_name')?.value  || '',
                            middle_name:       document.getElementById('student_middle_name')?.value || '',
                            birthdate:         document.getElementById('checklist-input-date')?.value || '',
                            sex:               document.getElementById('student_sex')?.value  || '',
                            age:               document.getElementById('student_age')?.value  || '',
                            father_name:       document.getElementById('father_full_name')?.value    || '',
                            mother_name:       document.getElementById('mother_full_name')?.value    || '',
                            guardian_name:     document.getElementById('guardian_full_name')?.value  || '',
                            guardian_contact:  document.getElementById('guardian_contact')?.value    || '',
                            address:           document.getElementById('student_address')?.value     || '',
                            category:          category
                        })
                    });

                    const resData = await response.json();
                    if (resData.status === 'success' && resData.id) {
                        window.location.href = `${target}?reg_id=${resData.id}`;
                        return;
                    }
                } catch (err) {
                    console.error('Checklist save failed:', err);
                    el.innerText = origText;
                    el.style.pointerEvents = '';
                }
            }

            window.location.href = target;
        }

        if (btnBasicEd)    btnBasicEd.addEventListener('click',    e => saveAndRedirect(e, btnBasicEd,    'basic_education'));
        if (btnCollegiate) btnCollegiate.addEventListener('click', e => saveAndRedirect(e, btnCollegiate, 'cg_studies'));

        // ─────────────────────────────────────────────────────────────────────
        const dpMONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        function pad(n) { return n < 10 ? '0' + n : '' + n; }
        function dateKey(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        let dpMonth = new Date().getMonth();
        let dpYear = new Date().getFullYear();
        const dpInput = document.getElementById('checklist-input-date');
        const dpDropdown = document.getElementById('checklist-datepicker');
        const dpMonthLabel = document.getElementById('dp-month-label');
        const dpYearBtn = document.getElementById('dp-year-btn');
        const dpDaysGrid = document.getElementById('dp-days');
        const dpCalendarView = document.getElementById('dp-calendar-view');
        const dpYearsView = document.getElementById('dp-years-view');
        const dpNav = document.getElementById('dp-nav');
        
        let currentView = 'calendar';

        function renderYears() {
            dpYearsView.innerHTML = '';
            const currentYearObj = new Date().getFullYear();
            for (let y = currentYearObj; y >= currentYearObj - 100; y--) {
                const yearEl = document.createElement('div');
                yearEl.className = 'dp-year-item';
                if (y === dpYear) yearEl.classList.add('selected');
                yearEl.textContent = y;
                yearEl.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dpYear = y;
                    currentView = 'calendar';
                    updateView();
                    renderDP();
                });
                dpYearsView.appendChild(yearEl);
            }
        }

        function updateView() {
            if (currentView === 'calendar') {
                dpCalendarView.classList.remove('hidden');
                dpYearsView.classList.remove('active');
                dpNav.style.visibility = 'visible';
            } else {
                dpCalendarView.classList.add('hidden');
                dpYearsView.classList.add('active');
                dpNav.style.visibility = 'hidden';
                setTimeout(() => {
                    const selectedYearEl = dpYearsView.querySelector('.dp-year-item.selected');
                    if (selectedYearEl) selectedYearEl.scrollIntoView({ block: 'center', behavior: 'instant' });
                }, 10);
            }
        }

        dpYearBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            currentView = currentView === 'calendar' ? 'years' : 'calendar';
            if (currentView === 'years') renderYears();
            updateView();
        });

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
                currentView = 'calendar';
                updateView();
                renderDP();
            }
        });

        document.addEventListener('click', (e) => {
            if (!dpDropdown.contains(e.target) && e.target !== dpInput) {
                dpDropdown.classList.remove('active');
            }
        });

        function renderDP() {
            dpMonthLabel.textContent = dpMONTHS[dpMonth];
            dpYearBtn.textContent = dpYear;
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
