<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Basic Education Records</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .header-simple {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            background: #ffffff;
            border-bottom: 
            z-index: 100;
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
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
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

        /* Nav style from Dashboard */
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
            gap: 0.6rem;
            padding: 0.8rem 1.4rem;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 14px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            font-size: 0.9rem;
        }

        .filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30,58,138,0.08);
        }

        .filter-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            width: 320px;
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            z-index: 100;
            padding: 1.5rem;
            display: none;
            flex-direction: column;
            gap: 1.5rem;
            animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .filter-dropdown.show { display: flex; }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 800;
            color: var(--text-muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-options {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .filter-option {
            padding: 0.6rem 0.8rem;
            border-radius: 10px;
            font-size: 0.85rem;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid transparent;
        }

        .filter-option:hover {
            background: rgba(30,58,138,0.04);
            color: var(--primary-color);
        }

        .filter-option.active {
            background: rgba(30,58,138,0.08);
            color: var(--primary-color);
            font-weight: 600;
            border-color: rgba(30,58,138,0.1);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-complete { background: #dcfce7; color: #166534; }
        .status-complete::before { background: #22c55e; }

        .status-incomplete { background: #fef9c3; color: #854d0e; }
        .status-incomplete::before { background: #eab308; }

        .status-error { background: #fee2e2; color: #991b1b; }
        .status-error::before { background: #ef4444; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body style="background-color: #f8fafc; display: block; align-items: flex-start; overflow-y: auto;">

    <!-- Simplified Header -->
    <header class="header-simple">
        <div class="header-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="Logo" class="header-logo">
            <span class="header-title">Records — Basic Education</span>
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Dashboard
        </a>
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
                    <!-- Student Name Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Student Name</span>
                        <div class="filter-options">
                            <div class="filter-option" onclick="applySort('first_name', 'asc')">First Name (Asc)</div>
                            <div class="filter-option" onclick="applySort('first_name', 'desc')">First Name (Desc)</div>
                            <div class="filter-option" onclick="applySort('last_name', 'asc')">Last Name (Asc)</div>
                            <div class="filter-option" onclick="applySort('last_name', 'desc')">Last Name (Desc)</div>
                        </div>
                    </div>

                    <!-- Grade Level Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Grade Level</span>
                        <div class="filter-options" style="grid-template-columns: 1fr 1fr; gap: 0.4rem;">
                            <div class="filter-option" onclick="applyFilter('grade', 'Kinder')">Kinder</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 1')">Grade 1</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 2')">Grade 2</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 3')">Grade 3</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 4')">Grade 4</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 5')">Grade 5</div>
                            <div class="filter-option" onclick="applyFilter('grade', 'Grade 6')">Grade 6</div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-group">
                        <span class="filter-group-title">Status</span>
                        <div class="filter-options">
                            <div class="filter-option" onclick="applyFilter('status', 'Complete')">
                                <span class="status-badge status-complete">Complete</span>
                            </div>
                            <div class="filter-option" onclick="applyFilter('status', 'Incomplete')">
                                <span class="status-badge status-incomplete">Incomplete</span>
                            </div>
                            <div class="filter-option" onclick="applyFilter('status', 'Error')">
                                <span class="status-badge status-error">Error</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="records-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Student Name</th>
                        <th style="width: 30%;">Grade Level</th>
                        <th style="width: 30%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Empty list for now, placeholder for DB integration --}}
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

        function applySort(field, direction) {
            console.log(`Sorting by ${field} ${direction}`);
            // Future database integration logic here
            document.getElementById('filter-dropdown').classList.remove('show');
        }

        function applyFilter(type, value) {
            console.log(`Filtering by ${type}: ${value}`);
            // Future database integration logic here
            document.getElementById('filter-dropdown').classList.remove('show');
        }
    </script>
</body>
</html>
