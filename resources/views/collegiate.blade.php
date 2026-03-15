<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Collegiate &amp; Graduate Studies</title>
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
            color: var(--primary-color);
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
    <nav class="checklist-nav">
        <div class="checklist-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="checklist-nav-logo">
            <h1>COLLEGIATE &amp; GRADUATE STUDIES</h1>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('checklist') }}" class="btn-back" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Checklist
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
            </form>
        </div>
    </nav>

    <!-- Sub Navbar -->
    <div class="sub-navbar">
        <span>Collegiate &amp; Graduate Studies — Student Records</span>
    </div>

    <!-- Main Content -->
    <main class="checklist-content">

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

        <!-- Program & Year Level -->
        <div class="section-card" id="section-program">
            <div class="section-title">Program & Year Level</div>
            <div class="field-row">
                <div class="field xwide">
                    <label>Program / Course</label>
                    <input type="text" name="program" placeholder="e.g. BS Computer Science">
                </div>
                <div class="field wide">
                    <label>Year Level</label>
                    <select name="year_level">
                        <option value="" disabled selected>Select Year</option>
                        <option>1st Year</option>
                        <option>2nd Year</option>
                        <option>3rd Year</option>
                        <option>4th Year</option>
                        <option>5th Year</option>
                        <option>Graduate / Masteral</option>
                        <option>Doctoral</option>
                    </select>
                </div>
                <div class="field medium">
                    <label>School Year</label>
                    <input type="text" name="school_year" placeholder="e.g. 2024–2025">
                </div>
                <div class="field narrow">
                    <label>Semester</label>
                    <select name="semester">
                        <option value="" disabled selected>Select</option>
                        <option>1st Semester</option>
                        <option>2nd Semester</option>
                        <option>Summer</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-bottom: 2rem;">
            <button type="submit" class="btn-login" style="padding: 0.8rem 3rem;">Save Information</button>
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
                    dpInput.closest('.section-card').classList.remove('has-open-picker');
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
        });
    </script>
</body>
</html>
