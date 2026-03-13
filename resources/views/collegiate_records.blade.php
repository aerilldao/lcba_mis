<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Collegiate & Graduate Records</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .header-simple {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2.5rem;
            background: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
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
    </style>
</head>
<body style="background-color: #f8fafc; display: block; align-items: flex-start; overflow-y: auto;">

    <!-- Simplified Header -->
    <header class="header-simple">
        <div class="header-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="Logo" class="header-logo">
            <span class="header-title">Records — Collegiate & Graduate</span>
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Dashboard
        </a>
    </header>

    <main class="records-container">
        
        <div class="records-list-card">
            <table class="records-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Student Name</th>
                        <th style="width: 30%;">Program / Year</th>
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

</body>
</html>
