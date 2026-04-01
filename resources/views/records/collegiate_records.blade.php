<!DOCTYPE html>
<html lang="en">
<head>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        </div>
    </header>

    <main class="records-container">
        <div class="records-list-card">
            <!-- Filter Section -->
            <div class="filter-section">
                <button class="filter-btn" id="filter-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                    </svg>
                    Filter & Sort
                </button>

                <div class="filter-dropdown" id="filter-dropdown">
                    <div style="display: flex; gap: 1.25rem; width: 100%;">
                        <!-- Name Sorting -->
                        <div class="filter-inner-card">
                            <div class="filter-group-title">Sorting</div>
                            <div class="sort-toggle-row">
                                <span style="font-size: 0.9rem; font-weight: 600; color: #fff;">Student Name</span>
                                <div class="sort-trigger" id="name-sort-trigger" onclick="toggleSort()">
                                    <span id="sort-direction-text">{{ request('sort') === 'desc' ? 'DESC' : 'ASC' }}</span>
                                    <svg id="sort-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        @if(request('sort') === 'desc')
                                            <path d="m16 14-4 4-4-4" />
                                            <path d="m8 10 4-4 4 4" />
                                        @else
                                            <path d="m16 10-4-4-4 4" />
                                            <path d="m8 14 4 4 4-4" />
                                        @endif
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- College Programs -->
                        <div class="filter-inner-card">
                            <div class="filter-group-title">Programs</div>
                            <div class="scroll-list" id="program-list">
                                @foreach(['BSCpE', 'BSCS', 'BS Political Science', 'BSE', 'BSA', 'BSBA', 'BS EDUC', 'BSPSYCH', 'MAEd', 'MBA', 'MSP', 'MM'] as $prog)
                                    <div class="list-item {{ request('program') === $prog ? 'active' : '' }}" onclick="selectFilter(this, 'program', '{{ $prog }}')">{{ $prog }}</div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Year Level -->
                        <div class="filter-inner-card">
                            <div class="filter-group-title">Year Level</div>
                            <div class="year-grid">
                                @foreach(['1st', '2nd', '3rd', '4th', '5th'] as $yr)
                                    <div class="year-option {{ request('year') === $yr ? 'active' : '' }}" onclick="selectFilter(this, 'year', '{{ $yr }}')">{{ $yr }}</div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-inner-card">
                            <div class="filter-group-title">Status Filter</div>
                            <div class="status-grid">
                                <div class="status-option complete {{ request('status') === 'Complete' ? 'active' : '' }}" onclick="selectFilter(this, 'status', 'Complete')">
                                    <div class="status-dot"></div>
                                    <span>Complete</span>
                                </div>
                                <div class="status-option incomplete {{ request('status') === 'Pending' ? 'active' : '' }}" onclick="selectFilter(this, 'status', 'Pending')">
                                    <div class="status-dot"></div>
                                    <span>Pending</span>
                                </div>
                                <div class="status-option error {{ request('status') === 'Error' ? 'active' : '' }}" onclick="selectFilter(this, 'status', 'Error')">
                                    <div class="status-dot"></div>
                                    <span>Error</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="filter-footer">
                        <button class="btn-reset-filters" onclick="resetFilters()">Reset All</button>
                        <button class="btn-apply-filters" onclick="applyFilters()">Apply Filters</button>
                    </div>
                </div>
            </div>

            <table class="records-table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Program / Year</th>
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
                            <td>{{ $rec->course }} / {{ $rec->year_level }}</td>
                            <td>
                                <div class="status-badge complete">Complete</div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem; flex-direction: column;">
                                    <a href="{{ route('collegiate', ['reg_id' => $rec->id]) }}" class="btn-update">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                        </svg>
                                        Update
                                    </a>
                                    <a href="{{ route('collegiate.print', ['id' => $rec->id]) }}" target="_blank" class="btn-print">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 6 2 18 2 18 9" />
                                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                            <rect x="6" y="14" width="12" height="8" />
                                        </svg>
                                        Print Form
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.2;">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
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
        const filterState = {
            sort: "{{ request('sort', 'asc') }}",
            program: "{{ request('program') }}",
            year: "{{ request('year') }}",
            status: "{{ request('status') }}"
        };

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
            filterState.sort = filterState.sort === 'asc' ? 'desc' : 'asc';

            text.innerText = filterState.sort.toUpperCase();
            if (filterState.sort === 'desc') {
                icon.innerHTML = '<path d="m16 14-4 4-4-4"/><path d="m8 10 4-4 4 4"/>';
            } else {
                icon.innerHTML = '<path d="m16 10-4-4-4 4"/><path d="m8 14 4 4 4-4"/>';
            }
        }

        function selectFilter(element, type, value) {
            // Remove active from peers
            const selector = element.classList.contains('list-item') ? '.list-item' :
                (element.classList.contains('year-option') ? '.year-option' : '.status-option');

            element.parentElement.querySelectorAll(selector).forEach(el => el.classList.remove('active'));

            if (filterState[type] === value) {
                filterState[type] = '';
            } else {
                element.classList.add('active');
                filterState[type] = value;
            }
        }

        function applyFilters() {
            const params = new URLSearchParams();
            if (filterState.sort && filterState.sort !== 'asc') params.set('sort', filterState.sort);
            if (filterState.program) params.set('program', filterState.program);
            if (filterState.year) params.set('year', filterState.year);
            if (filterState.status) params.set('status', filterState.status);

            window.location.href = "{{ route('collegiate_records') }}?" + params.toString();
        }

        function resetFilters() {
            window.location.href = "{{ route('collegiate_records') }}";
        }
    </script>
</body>
</html>
