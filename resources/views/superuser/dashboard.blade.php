<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Core Command</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/LCBA LOGO VECTOR.png') }}">
    <style>
        :root {
            --super-primary: #a78bfa;
            --super-accent: #d946ef;
            --super-bg: #0f172a;
            --super-bg-alt: #020617;
            --card-bg: rgba(30, 41, 59, 0.5);
            --card-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--super-bg-alt);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        @media (max-width: 1100px) {
            :root {
                --sidebar-width: 0px;
            }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 280px !important;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-container {
                margin-left: 0;
                padding: 1.5rem;
                max-width: 100vw;
            }
            .menu-toggle {
                display: flex !important;
            }
        }

        .sidebar {
            width: var(--sidebar-width);
            background: #0f172a;
            border-right: 1px solid var(--card-border);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 2.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            z-index: 2000;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 4rem;
            padding: 0 0.5rem;
        }

        .sidebar-logo img {
            height: 38px;
            filter: drop-shadow(0 0 8px var(--super-primary));
        }

        .sidebar-logo span {
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 0.1em;
            background: linear-gradient(135deg, var(--super-primary), var(--super-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-profile {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .profile-img-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--super-primary), var(--super-accent));
            padding: 3px;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 18px;
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .profile-img svg {
            width: 40px;
            height: 40px;
            color: var(--super-primary);
        }

        .profile-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .profile-role {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .nav-menu {
            list-style: none;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-radius: 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(167, 139, 250, 0.1);
            color: var(--super-primary);
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 2rem;
        }

        .theme-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(30, 41, 59, 0.5);
            padding: 0.75rem 1rem;
            border-radius: 14px;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Main Content Styles */
        .main-container {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 2.5rem 3rem;
            max-width: calc(100vw - var(--sidebar-width));
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .menu-toggle {
            display: none;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 0.75rem;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
        }

        .top-title h2 {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .search-box {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 200px;
            flex: 1;
        }

        .search-box input {
            background: none;
            border: none;
            color: #fff;
            width: 100%;
            font-family: inherit;
            font-size: 0.9rem;
        }

        .search-box input:focus { outline: none; }

        .btn-create {
            background: #fef08a; /* Yellow like "Upgrade" in reference */
            color: #000;
            padding: 0.75rem 1.5rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            transition: transform 0.2s ease;
        }

        .btn-create:hover { transform: scale(1.02); }

        /* Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: minmax(180px, auto);
            gap: 1.75rem;
            margin-bottom: 3rem;
        }

        @media (max-width: 1200px) {
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: 1fr;
            }
            .card-large, .card-wide, .intelligence-card {
                grid-column: span 1 !important;
            }
            .search-box {
                width: 100%;
                order: 3;
            }
            .top-actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        .bento-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-large { grid-column: span 1; grid-row: span 2; }
        .card-wide { grid-column: span 1; grid-row: span 1; }

        .card-reach {
            background: #fef08a;
            color: #000;
        }

        .card-reach .card-title { color: rgba(0,0,0,0.6); }
        .card-reach .reach-value { font-size: 4rem; font-weight: 800; line-height: 1; margin: 1.5rem 0; }

        .card-report {
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }

        .card-status {
            background: #f8fafc;
            color: #000;
        }

        .card-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-header { display: flex; align-items: center; gap: 0.5rem; }
        .status-badge-new { 
            background: #fef08a; 
            padding: 0.25rem 0.5rem; 
            border-radius: 8px; 
            font-weight: 800; 
            font-size: 0.7rem; 
        }

        /* User Table Component */
        .intelligence-card {
            grid-column: span 3;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 28px;
            padding: 2.5rem;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .user-table th {
            text-align: left;
            padding: 1rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .user-table td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }

        .user-info { display: flex; align-items: center; gap: 1rem; }
        .avatar-small { width: 40px; height: 40px; border-radius: 12px; background: rgba(167, 139, 250, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--super-primary); }

        .status-indicator { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 600; }
        .dot { width: 8px; height: 8px; border-radius: 50%; }
        .dot-active { background: #10b981; box-shadow: 0 0 10px #10b981; }
        .dot-idle { background: #64748b; }

        .action-icon-btn {
            background: rgba(255,255,255,0.05);
            border: none;
            color: var(--text-muted);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-icon-btn:hover { background: var(--super-primary); color: #000; }

        /* Existing Modal & Other Overrides */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(2, 6, 23, 0.9);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: 0.3s;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-card {
            background: #0f172a; border: 1px solid var(--card-border);
            width: 90%; max-width: 500px; border-radius: 28px; padding: 2.5rem;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA">
            <span>SUPER USER</span>
        </div>

        <div class="sidebar-footer" style="margin-top: auto;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="action-btn" style="width: 100%; padding: 0.8rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">Disconnect Session</button>
            </form>
        </div>
    </aside>

    <main class="main-container">
        <header class="top-bar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="top-title">
                    <h2>Statistics Overview</h2>
                </div>
            </div>
            <div class="top-actions">
                <div class="search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="Search system users...">
                </div>
                <a href="javascript:void(0)" class="btn-create" onclick="openCreateUserModal()">Add User</a>
                <button class="action-icon-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </button>
            </div>
        </header>

        <section class="bento-grid">
            <!-- Live System Status -->
            <div class="bento-card card-large" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="card-title">
                    <span>Live System Status</span>
                    <span style="font-size: 0.7rem; font-weight: 800; background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 0.2rem 0.6rem; border-radius: 6px;">SITE UP</span>
                </div>
                <div style="text-align: center; margin: 3rem 0;">
                    <div style="width: 120px; height: 120px; margin: 0 auto; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative;">
                        <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.2); border-radius: 50%; animation: pulse 2s infinite;"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position: absolute;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div style="font-size: 2.5rem; font-weight: 900; color: #10b981; margin-top: 1.5rem;">ONLINE</div>
                    <div style="font-weight: 700; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px;">Institutional Server</div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1.5rem; color: var(--text-muted);">
                    <span>Uptime</span>
                    <strong style="color: #fff;">99.99%</strong>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="bento-card" style="background: #fff; color: #000;">
                <div class="card-title">
                    <span style="color: #64748b;">Active Users</span>
                    <span style="font-size: 0.7rem; font-weight: 800; background: rgba(0,0,0,0.05); padding: 0.2rem 0.5rem; border-radius: 6px;">LIVE</span>
                </div>
                <div style="margin: 2rem 0; text-align: center;">
                    <div style="font-size: 4rem; font-weight: 900;">{{ $activeUsersCount }}</div>
                    <div style="font-weight: 800; font-size: 0.9rem; color: #64748b; margin-top: -0.5rem; text-transform: uppercase;">users online</div>
                    <div style="margin-top: 1.5rem; display: flex; justify-content: center; gap: 0.3rem;">
                        @for($i = 0; $i < 5; $i++)
                            <div style="width: 25px; height: 6px; background: {{ $i < $activeUsersCount ? '#000' : '#e2e8f0' }}; border-radius: 3px;"></div>
                        @endfor
                    </div>
                </div>
                <div style="font-size: 0.75rem; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1rem; color: #64748b;">
                    Monitoring real-time sessions
                </div>
            </div>

            <!-- Event Card (Summary) -->
            <div class="bento-card card-wide">
                <div class="card-title">
                    <span>System Database</span>
                    <span>Overview</span>
                </div>
                <div style="display: flex; gap: 3rem; margin-top: 1.5rem;">
                    <div>
                        <div style="font-size: 2.5rem; font-weight: 800;">{{ $totalUsers }}</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Total Users</div>
                    </div>
                    <div style="border-left: 1px solid rgba(255,255,255,0.05); padding-left: 3rem;">
                        <div style="font-size: 2.5rem; font-weight: 800;">{{ $totalEvents }}</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Events Logged</div>
                    </div>
                </div>
                <div style="margin-top: 2rem; background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--card-border); cursor: pointer; transition: 0.3s;" onclick="openAuditModal()">
                    <div style="font-size: 0.8rem; font-weight: 700;">Generate System Audit</div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
            </div>

            <!-- User Intelligence Center -->
            <div class="intelligence-card">
                <div class="card-title">
                    <span style="font-size: 1.1rem; color: #fff;">User Intelligence Center</span>
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('superuser.export') }}" class="action-btn" style="padding: 0.6rem 1.5rem; border-radius: 12px; font-size: 0.8rem; background: var(--super-accent); color: #fff; border: none; box-shadow: 0 4px 12px rgba(217, 70, 239, 0.3); text-decoration: none;">Export Registry</a>
                    </div>
                </div>
                
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Active Status</th>
                            <th>Access Group</th>
                            <th>Commands</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="avatar-small">{{ substr($user->name, 0, 1) }}</div>
                                    <div>
                                        <div style="font-weight: 700;">{{ $user->name }}</div>
                                        <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status-indicator">
                                    <div class="dot {{ $user->is_online ? 'dot-active' : 'dot-idle' }}"></div>
                                    {{ $user->is_online ? 'Online' : 'Offline' }}
                                </div>
                            </td>
                            <td>
                                <span style="font-size: 0.75rem; background: rgba(255,255,255,0.05); padding: 0.4rem 0.75rem; border-radius: 8px;">
                                    {{ $user->role_name ?? ($user->email === 'SUPERUSER' ? 'ROOT COMMAND' : 'STAFF ACCESS') }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button class="action-icon-btn" title="Edit User" onclick="openEditUserModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </button>
                                    <button class="action-icon-btn" title="User Events" onclick="openUserEventsModal({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </button>
                                    @if($user->email !== 'SUPERUSER')
                                    <button class="action-icon-btn" title="Log Out User" style="color: #ef4444; background: rgba(239, 68, 68, 0.1);" onclick="killUserSession({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Create User Modal -->
    <div class="modal-overlay" id="create-user-modal">
        <div class="modal-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 800;">Register User</h2>
                <button class="action-icon-btn" onclick="closeModal('create-user-modal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="create-user-form">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Full User Name</label>
                    <input type="text" id="create-user-name" name="name" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;" required>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Access Email</label>
                    <input type="text" id="create-user-email" name="email" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;" required>
                </div>
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Command Password</label>
                    <input type="password" id="create-user-password" name="password" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;" required>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" class="btn-cancel" style="flex: 1; padding: 1rem; border-radius: 12px; background: none; border: 1px solid var(--card-border); color: #fff; cursor: pointer;" onclick="closeModal('create-user-modal')">Abort</button>
                    <button type="submit" style="flex: 1; padding: 1rem; border-radius: 12px; background: var(--super-primary); border: none; color: #000; font-weight: 800; cursor: pointer;">Initialize User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Identity Modal -->
    <div class="modal-overlay" id="edit-user-modal">
        <div class="modal-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 800;">Update User</h2>
                <button class="action-icon-btn" onclick="closeModal('edit-user-modal')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <form id="edit-user-form">
                <input type="hidden" id="edit-user-id">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Full User Name</label>
                    <input type="text" id="edit-user-name" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;" required>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Access Email</label>
                    <input type="text" id="edit-user-email" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;" required>
                </div>
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Command Password Override</label>
                    <input type="password" id="edit-user-password" placeholder="Leave blank to keep current" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--card-border); padding: 1rem; border-radius: 12px; color: #fff;">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" class="btn-cancel" style="flex: 1; padding: 1rem; border-radius: 12px; background: none; border: 1px solid var(--card-border); color: #fff; cursor: pointer;" onclick="closeModal('edit-user-modal')">Abort</button>
                    <button type="submit" style="flex: 1; padding: 1rem; border-radius: 12px; background: var(--super-primary); border: none; color: #000; font-weight: 800; cursor: pointer;">Apply Override</button>
                </div>
                <div style="margin-top: 1.5rem; text-align: center;">
                    <button type="button" id="btn-delete-user" style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; text-decoration: underline; font-size: 0.85rem;">Permanently Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- User Events Modal -->
    <div class="modal-overlay" id="user-events-modal">
        <div class="modal-card" style="max-width: 650px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                <h2 style="font-size: 1.75rem; font-weight: 800;" id="events-modal-title">User Events</h2>
                <button class="action-icon-btn" onclick="closeModal('user-events-modal')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div id="event-list-container" style="max-height: 400px; overflow-y: auto;">
                <!-- Events will be loaded here -->
            </div>
        </div>
    </div>

    <!-- System Audit Modal -->
    <div class="modal-overlay" id="audit-modal">
        <div class="modal-card" style="max-width: 800px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-size: 1.75rem; font-weight: 800;">System Administrative Audit</h2>
                    <p style="color: var(--text-muted); font-size: 0.85rem;">Full list of system users and access credentials</p>
                </div>
                <button class="action-icon-btn" onclick="closeModal('audit-modal')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div style="max-height: 500px; overflow-y: auto; background: rgba(0,0,0,0.2); border-radius: 16px; border: 1px solid var(--card-border);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid var(--card-border);">
                            <th style="padding: 1rem; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase;">Name</th>
                            <th style="padding: 1rem; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase;">Email</th>
                            <th style="padding: 1rem; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase;">Security Status</th>
                            <th style="padding: 1rem; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase;">Group</th>
                        </tr>
                    </thead>
                    <tbody id="audit-table-body">
                        <!-- Audit data will be loaded here -->
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 1.5rem; text-align: right;">
                <button class="btn-create" onclick="window.print()" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--card-border);">Download as PDF</button>
            </div>
        </div>
    </div>

    <script>
        function openCreateUserModal() {
            document.getElementById('create-user-modal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // Create User Logic
        document.getElementById('create-user-form').onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('{{ route('superuser.users.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                } else {
                    alert('Error creating identity. Please check inputs.');
                }
            });
        };

        // Edit User Modal Logic
        function openEditUserModal(id, name, email) {
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-user-name').value = name;
            document.getElementById('edit-user-email').value = email;
            document.getElementById('edit-user-password').value = '';
            
            const deleteBtn = document.getElementById('btn-delete-user');
            if (email === 'SUPERUSER') {
                deleteBtn.style.display = 'none';
            } else {
                deleteBtn.style.display = 'inline-block';
                deleteBtn.onclick = () => deleteUser(id);
            }
            
            document.getElementById('edit-user-modal').classList.add('active');
        }

        document.getElementById('edit-user-form').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('edit-user-id').value;
            const data = {
                name: document.getElementById('edit-user-name').value,
                email: document.getElementById('edit-user-email').value,
                password: document.getElementById('edit-user-password').value,
                _token: '{{ csrf_token() }}'
            };

            fetch(`/superuser/users/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') location.reload();
            });
        };

        function deleteUser(id) {
            if(!confirm('Are you sure you want to delete this user? This cannot be undone.')) return;
            
            fetch(`/superuser/users/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') location.reload();
            });
        }

        function openUserEventsModal(id, name) {
            document.getElementById('events-modal-title').textContent = `${name}'s Registered Events`;
            const container = document.getElementById('event-list-container');
            container.innerHTML = '<p style="text-align: center; color: var(--text-muted);">Accessing institution logs...</p>';
            
            document.getElementById('user-events-modal').classList.add('active');

            fetch(`/superuser/users/${id}/events`)
            .then(res => res.json())
            .then(events => {
                if(events.length === 0) {
                    container.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-muted);">No records found for this identity.</div>';
                    return;
                }

                container.innerHTML = events.map(event => `
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--card-border); padding: 1.25rem; border-radius: 16px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 800; font-size: 1rem; color: #fff;">${event.title}</div>
                            <div style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.25rem;">
                                ${event.event_date} ${event.event_time || ''}
                            </div>
                        </div>
                        <button class="action-icon-btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;" onclick="deleteAdminEvent(${event.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </div>
                `).join('');
            });
        }

        function deleteAdminEvent(id) {
            if(!confirm('Confirm event deletion?')) return;
            
            fetch(`/superuser/events/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                }
            });
        }

        function killUserSession(id, name) {
            if(!confirm(`Are you sure you want to log out ${name}? They will be instantly disconnected from their active session.`)) return;

            fetch(`/superuser/users/${id}/kill-session`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    location.reload();
                } else {
                    alert('Command failed: ' + (data.error || 'Unknown error'));
                }
            });
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.querySelector('.menu-toggle');
            if (window.innerWidth <= 1100 && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // New Administrative Functions
        function openAuditModal() {
            const body = document.getElementById('audit-table-body');
            body.innerHTML = '<tr><td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted);">Deciphering system records...</td></tr>';
            document.getElementById('audit-modal').classList.add('active');

            fetch('{{ route('superuser.audit') }}')
            .then(res => res.json())
            .then(users => {
                body.innerHTML = users.map(user => `
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                        <td style="padding: 1.25rem 1rem; font-weight: 700;">${user.name}</td>
                        <td style="padding: 1.25rem 1rem; color: var(--super-primary);">${user.email}</td>
                        <td style="padding: 1.25rem 1rem;">
                            <span style="font-size: 0.75rem; background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.3rem 0.6rem; border-radius: 6px;">${user.password_status}</span>
                        </td>
                        <td style="padding: 1.25rem 1rem; font-size: 0.8rem; font-weight: 600;">${user.role}</td>
                    </tr>
                `).join('');
            });
        }
    </script>
</body>
</html>
