<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Checklist</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .dashboard-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 1rem 2rem;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
        }

        .dashboard-nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard-nav-logo {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .dashboard-nav h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 0.05em;
            margin: 0;
        }

        .dashboard-content {
            margin-top: 100px;
            padding: 2rem;
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body style="align-items: flex-start; background-color: #f8fafc;">
    <!-- Navigation Bar -->
    <nav class="dashboard-nav">
        <div class="dashboard-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="dashboard-nav-logo">
            <h1>CHECKLIST MODULE</h1>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('dashboard') }}" class="btn-back" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Back to Dashboard
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="dashboard-content">
        <div class="card" style="width: 100%; max-width: 800px; padding: 2rem;">
            <h2 style="color: var(--primary-color); margin-bottom: 1rem;">Checklist Form Configuration</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Build your specific checklist features here. Submitting forms from this page will update the department values on the dashboard later.</p>
            
            <div style="padding: 3rem; border: 2px dashed rgba(0,0,0,0.1); border-radius: 12px; text-align: center;">
                <span style="color: var(--text-muted);">Checklist Form Placeholder</span>
            </div>
        </div>
    </main>
</body>
</html>
