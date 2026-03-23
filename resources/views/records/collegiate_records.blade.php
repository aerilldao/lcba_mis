<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Collegiate & Graduate Records'])

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
                    @forelse($records as $rec)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $rec->last_name }}, {{ $rec->first_name }} {{ $rec->middle_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $rec->id_no }}</div>
                        </td>
                        <td>{{ $rec->course }} / {{ $rec->year_level }}</td>
                        <td>
                            @php $status = $rec->registration_status; @endphp
                            <div class="status-option {{ $status->class }} active" style="padding: 0.3rem 0.6rem; font-size: 0.7rem; display: inline-flex; pointer-events: none; background-color: {{ $status->color }}; color: white; border-radius: 8px;">
                                <span>{{ $status->label }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem; flex-direction: column;">
                                <a href="{{ route('collegiate', ['reg_id' => $rec->id]) }}" class="btn-update">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    Update
                                </a>
                                <a href="{{ route('collegiate.print', ['id' => $rec->id]) }}" target="_blank" class="btn-update" style="background: rgba(0,0,0,0.05); color: var(--text-main); border-color: var(--card-border);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                                    Print Form
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.2;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <p>No student records currently available.</p>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Records will appear here once the database is integrated.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
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
