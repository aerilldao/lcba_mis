<!DOCTYPE html>
<html lang="en">
    @include('partials.head', ['title' => 'LCBA - Basic Education Records'])

</head>
<body style="background-color: var(--bg-alt); display: block; align-items: flex-start; overflow-y: auto;">

    <!-- Simplified Header -->
    <header class="header-simple">
        <div class="header-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="Logo" class="header-logo">
            <span class="header-title">Records — Basic Education</span>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('dashboard') }}" class="nav-link-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </div>
    </header>

    <main class="records-container basic-ed-records-section">
        
        <div class="records-list-card">
            
            <!-- Filter Section -->
            <div class="filter-section">
                <button class="filter-btn" id="filter-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Filter & Sort
                </button>

                <div class="filter-dropdown" id="filter-dropdown">
                    <!-- Card 1: Name Sorting -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Sorting</div>
                        <div class="sort-toggle-row">
                            <span class="sort-label">Student Name</span>
                            <div class="sort-trigger" id="name-sort-trigger" onclick="toggleSort()">
                                <span id="sort-direction-text">ASC</span>
                                <svg id="sort-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m16 10-4-4-4 4"/><path d="m8 14 4 4 4-4"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Grade Level Scroll -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Grade Level</div>
                        <div class="grade-scroll-container">
                            <div class="grade-item" onclick="selectGrade(this, 'Kinder')">Kinder</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 1')">Grade 1</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 2')">Grade 2</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 3')">Grade 3</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 4')">Grade 4</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 5')">Grade 5</div>
                            <div class="grade-item" onclick="selectGrade(this, 'Grade 6')">Grade 6</div>
                        </div>
                    </div>

                    <!-- Card 3: Status Grid -->
                    <div class="filter-inner-card">
                        <div class="filter-group-title">Status Filter</div>
                        <div class="status-grid">
                            <div class="status-option complete" onclick="selectStatus(this, 'Complete')">
                                <div class="status-dot"></div>
                                <span>Complete</span>
                            </div>
                            <div class="status-option incomplete" onclick="selectStatus(this, 'Incomplete')">
                                <div class="status-dot"></div>
                                <span>Pending</span>
                            </div>
                            <div class="status-option error" onclick="selectStatus(this, 'Error')">
                                <div class="status-dot"></div>
                                <span>Error</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="records-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Grade Level</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $rec)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $rec->last_name }}, {{ $rec->first_name }} {{ $rec->middle_name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $rec->id_no }}</div>
                        </td>
                        <td>{{ $rec->grade_level }}</td>
                        <td>
                            <div class="status-badge complete">Complete</div>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.75rem; flex-direction: column;">
                                <a href="{{ route('basic_education', ['reg_id' => $rec->id]) }}" class="btn-update">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    Update
                                </a>
                                <a href="{{ route('basic_education.print', ['id' => $rec->id]) }}" target="_blank" class="btn-print">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
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
        let activeGrade = null;
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
            console.log(`Sort changed to: ${currentSort}`);
        }

        function selectGrade(element, grade) {
            document.querySelectorAll('.grade-item').forEach(el => el.classList.remove('active'));
            if (activeGrade === grade) {
                activeGrade = null;
            } else {
                element.classList.add('active');
                activeGrade = grade;
            }
            console.log(`Grade selected: ${activeGrade}`);
        }

        function selectStatus(element, status) {
            document.querySelectorAll('.status-option').forEach(el => el.classList.remove('active'));
            if (activeStatus === status) {
                activeStatus = null;
            } else {
                element.classList.add('active');
                activeStatus = status;
            }
            console.log(`Status selected: ${activeStatus}`);
        }
    </script>
</body>
</html>
