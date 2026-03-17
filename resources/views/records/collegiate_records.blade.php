<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Collegiate & Graduate Records'])
    <style>
        .header-simple {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            background: var(--header-bg);
            border-bottom: 1px solid var(--card-border);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background-color 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .header-logo {
            height: 45px;
            width: auto;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 0.02em;
        }

        .records-container {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .records-list-card {
            background: var(--bg-main);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .records-table th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            padding: 1rem;
            border-bottom: 2px solid rgba(0,0,0,0.03);
            font-weight: 700;
        }

        .records-table td {
            padding: 1.25rem 1rem;
            font-size: 0.95rem;
            border-bottom: 1px solid rgba(0,0,0,0.02);
        }

        .empty-placeholder {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
        }

        .empty-placeholder p {
            font-size: 1rem;
            margin-top: 1rem;
            font-weight: 500;
        }

        .nav-link-btn {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.2s;
        }
        .nav-link-btn:hover { color: var(--primary-color); }

        /* Filter Section Styles */
        .filter-section {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 2rem;
            position: relative;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 1.6rem;
            background: var(--bg-main);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            font-weight: 700;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            font-family: 'Outfit', sans-serif;
        }

        .filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30,58,138,0.1);
        }

        .filter-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            left: 0;
            width: 920px;
            background: var(--header-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            z-index: 200;
            padding: 1.5rem;
            display: none;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            max-height: 80vh;
            overflow-y: auto;
            animation: slideDownFade 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            transition: background-color 0.3s ease;
        }

        .filter-dropdown::-webkit-scrollbar { width: 5px; }
        .filter-dropdown::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.05); border-radius: 10px; }

        .filter-dropdown.show { display: grid; }

        .filter-inner-card {
            background: var(--bg-main);
            border-radius: 18px;
            padding: 1.25rem;
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .filter-inner-card:hover { border-color: rgba(30,58,138,0.1); }

        .filter-group-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Sorting */
        .sort-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.25rem;
        }

        .sort-trigger {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(30,58,138,0.05);
            border-radius: 12px;
            color: var(--primary-color);
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        /* Scrollable Lists */
        .scroll-list {
            max-height: 120px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            padding-right: 0.5rem;
        }

        .scroll-list::-webkit-scrollbar { width: 4px; }
        .scroll-list::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }

        .list-item {
            padding: 0.6rem 0.8rem;
            border-radius: 10px;
            font-size: 0.85rem;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
        }

        .list-item:hover { background: rgba(30,58,138,0.04); color: var(--primary-color); }
        .list-item.active { background: var(--primary-color); color: #ffffff; }

        /* Year Grid */
        .year-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.5rem;
        }

        .year-option {
            padding: 0.6rem 0.2rem;
            border-radius: 10px;
            background: rgba(0,0,0,0.02);
            font-size: 0.8rem;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .year-option:hover { background: rgba(30,58,138,0.05); color: var(--primary-color); }
        .year-option.active { background: var(--primary-color); color: #ffffff; border-color: var(--primary-color); }

        /* Status Grid */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.6rem;
        }

        .status-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            padding: 0.75rem 0.5rem;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
            text-align: center;
        }

        .status-option.complete { background: #f0fdf4; color: #166534; }
        .status-option.incomplete { background: #fffbeb; color: #854d0e; }
        .status-option.error { background: #fef2f2; color: #991b1b; }
        
        .status-option:hover { opacity: 0.8; }
        .status-option.active.complete { background: #22c55e; color: #ffffff; }
        .status-option.active.incomplete { background: #eab308; color: #ffffff; }
        .status-option.active.error { background: #ef4444; color: #ffffff; }

        .status-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }

        /* Update Button Styles */
        .btn-update {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: rgba(30,58,138,0.05);
            color: var(--primary-color);
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(30,58,138,0.1);
        }

        .btn-update:hover {
            background: var(--primary-color);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30,58,138,0.15);
        }

        @keyframes slideDownFade {
            from { opacity: 0; transform: translateY(-15px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body style="background-color: var(--bg-alt); display: block; align-items: flex-start; overflow-y: auto;">

    <!-- Simplified Header -->
    <header class="header-simple">
        <div class="header-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="Logo" class="header-logo">
            <span class="header-title">Records — Collegiate & Graduate</span>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('dashboard') }}" class="nav-link-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
            </form>
        </div>
    </header>

    <main class="records-container">
        
        <div class="records-list-card">
            <!-- Filter Section -->
            <div class="filter-section">
                <button class="filter-btn" id="filter-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Filter & Sort
                </button>

                <div class="filter-dropdown" id="filter-dropdown">
                    <!-- Name Sorting -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Sorting</div>
                        <div class="sort-toggle-row">
                            <span style="font-size: 0.9rem; font-weight: 600;">Student Name</span>
                            <div class="sort-trigger" id="name-sort-trigger" onclick="toggleSort()">
                                <span id="sort-direction-text">ASC</span>
                                <svg id="sort-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m16 10-4-4-4 4"/><path d="m8 14 4 4 4-4"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- College Programs -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">College Programs</div>
                        <div class="scroll-list" id="college-programs-list">
                            <div class="list-item" onclick="selectItem(this, 'college')">BSCpE</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BSCS</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BS Political Science</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BSE</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BSA</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BSBA</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BS EDUC</div>
                            <div class="list-item" onclick="selectItem(this, 'college')">BSPSYCH</div>
                        </div>
                    </div>

                    <!-- Graduate Studies -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Graduate Studies</div>
                        <div class="scroll-list" id="graduate-programs-list">
                            <div class="list-item" onclick="selectItem(this, 'graduate')">MAEd</div>
                            <div class="list-item" onclick="selectItem(this, 'graduate')">MBA</div>
                            <div class="list-item" onclick="selectItem(this, 'graduate')">MSP</div>
                            <div class="list-item" onclick="selectItem(this, 'graduate')">MM</div>
                        </div>
                    </div>

                    <!-- Year Level -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Year Level</div>
                        <div class="year-grid">
                            <div class="year-option" onclick="selectYear(this, '1st')">1st</div>
                            <div class="year-option" onclick="selectYear(this, '2nd')">2nd</div>
                            <div class="year-option" onclick="selectYear(this, '3rd')">3rd</div>
                            <div class="year-option" onclick="selectYear(this, '4th')">4th</div>
                            <div class="year-option" onclick="selectYear(this, '5th')">5th</div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Status Filter</div>
                        <div class="status-grid">
                            <div class="status-option complete" onclick="selectStatus(this, 'Complete')">
                                <div class="status-dot"></div>
                                <span style="font-size: 0.65rem;">Complete</span>
                            </div>
                            <div class="status-option incomplete" onclick="selectStatus(this, 'Incomplete')">
                                <div class="status-dot"></div>
                                <span style="font-size: 0.65rem;">Pending</span>
                            </div>
                            <div class="status-option error" onclick="selectStatus(this, 'Error')">
                                <div class="status-dot"></div>
                                <span style="font-size: 0.65rem;">Error</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="records-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Student Name</th>
                        <th style="width: 25%;">Program / Year</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Mock record for demonstration --}}
                    <tr>
                        <td>
                            <div style="font-weight: 600;">Santos, Maria Clara</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">2024-0089</div>
                        </td>
                        <td>BSCpE / 4th Year</td>
                        <td>
                            <div class="status-option incomplete active" style="padding: 0.3rem 0.6rem; font-size: 0.7rem; display: inline-flex; pointer-events: none;">
                                <span>Pending</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('checklist') }}" class="btn-update">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                Update
                            </a>
                        </td>
                    </tr>
                    {{-- Placeholder for DB integration --}}
                    <tr>
                        <td colspan="3">
                            <div class="empty-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.2;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <p>No student records currently available.</p>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Records will appear here once the database is integrated.</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <script>
        let currentSort = 'asc';
        let activeCollegeProgram = null;
        let activeGraduateProgram = null;
        let activeYear = null;
        let activeStatus = null;

        document.getElementById('filter-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('filter-dropdown').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('filter-dropdown');
            if (!dropdown.contains(e.target) && e.target.id !== 'filter-btn') {
                dropdown.classList.remove('show');
            }
        });

        function toggleSort() {
            const text = document.getElementById('sort-direction-text');
            const icon = document.getElementById('sort-icon');
            if (currentSort === 'asc') {
                currentSort = 'desc';
                text.innerText = 'DESC';
                icon.innerHTML = '<path d="m16 14-4 4-4-4"/><path d="m8 10 4-4 4 4"/>';
            } else {
                currentSort = 'asc';
                text.innerText = 'ASC';
                icon.innerHTML = '<path d="m16 10-4-4-4 4"/><path d="m8 14 4 4 4-4"/>';
            }
        }

        function selectItem(element, type) {
            const selector = type === 'college' ? '#college-programs-list .list-item' : '#graduate-programs-list .list-item';
            document.querySelectorAll(selector).forEach(el => el.classList.remove('active'));
            
            if (type === 'college') {
                if (activeCollegeProgram === element.innerText) { activeCollegeProgram = null; }
                else { element.classList.add('active'); activeCollegeProgram = element.innerText; }
            } else {
                if (activeGraduateProgram === element.innerText) { activeGraduateProgram = null; }
                else { element.classList.add('active'); activeGraduateProgram = element.innerText; }
            }
        }

        function selectYear(element, year) {
            document.querySelectorAll('.year-option').forEach(el => el.classList.remove('active'));
            if (activeYear === year) { activeYear = null; }
            else { element.classList.add('active'); activeYear = year; }
        }

        function selectStatus(element, status) {
            document.querySelectorAll('.status-option').forEach(el => el.classList.remove('active'));
            if (activeStatus === status) { activeStatus = null; }
            else { element.classList.add('active'); activeStatus = status; }
        }
    </script>
</body>
</html>
