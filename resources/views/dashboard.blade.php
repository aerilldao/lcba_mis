<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dark-mode.js') }}"></script>
    <style>
        .dashboard-nav {
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
            max-width: 1400px;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }
        }

        /* Easter Egg Styles */
        .easter-egg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.5s ease;
            cursor: pointer;
        }
        .easter-egg-overlay.active {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
        }
        .easter-egg-logo {
            width: clamp(100px, 15vw, 200px);
            height: auto;
            transform: scale(0.2);
            transition: transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 0 30px rgba(59, 130, 246, 0.5));
        }
        .easter-egg-overlay.active .easter-egg-logo {
            transform: scale(3);
        }
        .easter-egg-text {
            margin-top: 15rem;
            color: #ffffff;
            font-size: clamp(1rem, 3vw, 1.5rem);
            font-weight: 800;
            letter-spacing: 0.3em;
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.6s;
            text-shadow: 0 0 20px rgba(255,255,255,0.3);
        }
        .easter-egg-overlay.active .easter-egg-text {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body style="align-items: flex-start; background-color: var(--bg-alt);">
    <!-- Navigation Bar -->
    <nav class="dashboard-nav">
        <div class="dashboard-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="dashboard-nav-logo">
            <h1>DASHBOARD</h1>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()" class="btn-login" style="padding: 0.5rem; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--bg-alt); color: var(--text-main); border: 1px solid var(--card-border); cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
            </button>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="dashboard-content">
        
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem; position: sticky; top: 110px; height: calc(100vh - 140px);">
            
            <!-- Quick Notes -->
            <div class="card dashboard-main-area" style="width: 100%; padding: 2rem; flex: 1; display: flex; flex-direction: column;">
                <h2 style="color: var(--primary-color); margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    Quick Notes
                    <span id="save-indicator" style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted); opacity: 0; transition: opacity 0.3s;">Saving...</span>
                </h2>
                <textarea id="quick-notes" style="flex: 1; min-height: 150px; width: 100%; border: none; resize: none; outline: none; background: transparent; font-family: inherit; font-size: 1.05rem; color: var(--text-main); line-height: 1.6; position: relative; z-index: 1;" placeholder="Type your notes here...">{{ auth()->user()->quick_notes }}</textarea>
            </div>

            <!-- Bottom Row: Functions & Detailed Stats -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
                <style>
                    .stat-inner-card {
                        background: var(--bg-main);
                        border: 1px solid var(--card-border);
                        border-radius: 16px;
                        padding: 1.5rem 1rem;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        gap: 0.25rem;
                        transition: all 0.3s ease;
                        position: relative;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
                    }
                    .stat-inner-card:hover {
                        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
                        border-color: rgba(0,0,0,0.12);
                    }
                    .btn-view-records {
                        margin-top: 0.75rem;
                        padding: 0.6rem 1.4rem;
                        font-size: 0.75rem;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 0.08em;
                        text-decoration: none;
                        border-radius: 10px;
                        transition: all 0.2s ease;
                        position: relative;
                        z-index: 20; /* Ensure it's above everything */
                        display: inline-block;
                    }
                    .btn-view-records.basic {
                        color: var(--primary-color);
                        background: rgba(30, 58, 138, 0.06);
                        border: 1px solid rgba(30, 58, 138, 0.1);
                    }
                    .btn-view-records.basic:hover {
                        background: var(--primary-color);
                        color: #ffffff;
                        transform: scale(1.05);
                        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
                    }
                    .btn-view-records.collegiate {
                        color: var(--accent-color);
                        background: rgba(245, 158, 11, 0.06);
                        border: 1px solid rgba(245, 158, 11, 0.1);
                    }
                    .btn-view-records.collegiate:hover {
                        background: var(--accent-color);
                        color: #ffffff;
                        transform: scale(1.05);
                        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
                    }
                </style>
                
                <!-- Functions & General Stats -->
                <div class="card" style="width: 100%; padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; position: relative; z-index: 5;">
                    <a href="{{ route('checklist') }}" class="btn-login" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; width: 100%; height: 62px; font-size: 1.1rem; border-radius: 14px; position: relative; z-index: 10; font-weight: 700;">Open Checklist</a>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="stat-inner-card">
                            <h4 style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 800; margin-bottom: 0.25rem;">Basic Education</h4>
                            <span style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color); line-height: 1;">0</span>
                            <a href="{{ route('basic_education_records') }}" class="btn-view-records basic">View Records</a>
                        </div>

                        <div class="stat-inner-card">
                            <h4 style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 800; margin-bottom: 0.25rem;">College &amp; Graduate</h4>
                            <span style="font-size: 2.5rem; font-weight: 800; color: var(--accent-color); line-height: 1;">0</span>
                            <a href="{{ route('collegiate_records') }}" class="btn-view-records collegiate">View Records</a>
                        </div>
                    </div>
                </div>

                <!-- Detailed Counters -->
                <div class="card" style="width: 100%; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; align-items: center; text-align: center;">
                    <h3 style="color: var(--primary-color); font-size: 1.15rem; margin-bottom: 0.5rem;">Enrollment Breakdown</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; flex: 1; width: 100%;">
                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #10b981;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Kinder to Elem.</span>
                            <div style="width: 100%; height: 6px; background: rgba(16, 185, 129, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #10b981; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #3b82f6;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Junior High</span>
                            <div style="width: 100%; height: 6px; background: rgba(59, 130, 246, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #3b82f6; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #8b5cf6;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Senior High</span>
                            <div style="width: 100%; height: 6px; background: rgba(139, 92, 246, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #8b5cf6; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>

                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column; align-items: center;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #0ea5e9;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">College</span>
                            <div style="width: 100%; height: 6px; background: rgba(14, 165, 233, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #0ea5e9; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding-top: 0.5rem; display: flex; flex-direction: column; align-items: center; grid-column: span 2; width: calc(50% - 0.5rem); margin: 0 auto;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #f59e0b;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Graduate Studies</span>
                            <div style="width: 100%; height: 6px; background: rgba(245, 158, 11, 0.1); border-radius: 4px; overflow: hidden; margin-top: 0.5rem;">
                                <div style="width: 0%; height: 100%; background: #f59e0b; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>

        <!-- Right Sidebar (Calendar) -->
        <style>
            .calendar-sidebar {
                padding: 1.5rem;
                width: 100%;
                min-width: 0;
                position: sticky;
                top: 110px;
                height: calc(100vh - 140px);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                align-items: stretch;
            }

            /* Disable the base .card hover transform so buttons stay clickable */
            .calendar-sidebar:hover {
                transform: none !important;
                box-shadow: none !important;
            }

            .calendar-sidebar::before {
                display: none !important;
            }

            .calendar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.25rem;
                flex-shrink: 0;
                position: relative;
                z-index: 5;
            }

            .calendar-header h3 {
                color: var(--primary-color);
                font-size: 1.35rem;
                font-weight: 800;
                letter-spacing: -0.01em;
            }

            .calendar-nav {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .calendar-month-label {
                font-size: 0.85rem;
                font-weight: 700;
                color: var(--text-main);
                min-width: 110px;
                text-align: center;
                letter-spacing: 0.03em;
                text-transform: uppercase;
            }

            .calendar-nav-btn {
                background: var(--bg-alt);
                border: 1px solid var(--card-border);
                color: var(--text-main);
                width: 30px;
                height: 30px;
                border-radius: 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                font-size: 0.85rem;
                font-weight: 700;
            }

            .calendar-nav-btn:hover {
                background: var(--primary-color);
                color: #fff;
                border-color: var(--primary-color);
            }

            .calendar-weekdays {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 3px;
                margin-bottom: 3px;
                flex-shrink: 0;
            }

            .calendar-weekday {
                text-align: center;
                font-size: 0.65rem;
                font-weight: 800;
                color: var(--text-muted);
                text-transform: uppercase;
                letter-spacing: 0.08em;
                padding: 0.4rem 0;
            }

            .calendar-grid {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 3px;
                flex: 1;
                overflow-y: auto;
                align-content: stretch;
            }

            .calendar-day {
                background: var(--bg-alt);
                border: 1px solid var(--card-border);
                border-radius: 10px;
                padding: 0.5rem;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                flex-direction: column;
                position: relative;
            }

            .calendar-day:hover {
                border-color: var(--secondary-color);
                box-shadow: 0 2px 8px rgba(59, 130, 246, 0.12);
                transform: translateY(-1px);
            }

            .calendar-day.today {
                border-color: var(--primary-color);
                background: rgba(30, 58, 138, 0.06);
            }

            .dark-mode .calendar-day.today {
                background: rgba(59, 130, 246, 0.1);
            }

            .calendar-day.other-month {
                opacity: 0.35;
            }

            .calendar-day-number {
                font-size: 0.75rem;
                font-weight: 700;
                color: var(--text-main);
                margin-bottom: 2px;
                line-height: 1;
            }

            .calendar-day.today .calendar-day-number {
                color: var(--primary-color);
                font-weight: 800;
            }

            .calendar-event-dots {
                display: flex;
                flex-wrap: wrap;
                gap: 3px;
                margin-top: auto;
            }

            .calendar-event-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .calendar-add-btn {
                margin-top: 0.75rem;
                flex-shrink: 0;
                width: 100%;
                padding: 0.6rem;
                border: 2px dashed var(--card-border);
                border-radius: 12px;
                background: transparent;
                color: var(--text-muted);
                font-family: inherit;
                font-size: 0.8rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
                position: relative;
                z-index: 5;
            }

            .calendar-add-btn:hover {
                border-color: var(--primary-color);
                color: var(--primary-color);
                background: rgba(30, 58, 138, 0.04);
            }

            /* Modal Overlay */
            .cal-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .cal-modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .cal-modal {
                background: var(--bg-main);
                border: 1px solid var(--card-border);
                border-radius: 20px;
                padding: 2rem;
                width: 90%;
                max-width: 420px;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
                transform: translateY(20px) scale(0.97);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .cal-modal-overlay.active .cal-modal {
                transform: translateY(0) scale(1);
            }

            .cal-modal h3 {
                color: var(--primary-color);
                font-size: 1.3rem;
                font-weight: 800;
                margin-bottom: 1.25rem;
            }

            .cal-modal-field {
                margin-bottom: 1rem;
            }

            .cal-modal-field label {
                display: block;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--text-muted);
                margin-bottom: 0.4rem;
            }

            .cal-modal-field input,
            .cal-modal-field textarea {
                width: 100%;
                padding: 0.7rem 0.9rem;
                border: 1px solid var(--card-border);
                border-radius: 10px;
                background: var(--input-bg);
                color: var(--text-main);
                font-family: inherit;
                font-size: 0.9rem;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .cal-modal-field input:focus,
            .cal-modal-field textarea:focus {
                border-color: var(--secondary-color);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
            }

            .cal-modal-field textarea {
                resize: vertical;
                min-height: 60px;
            }

            .cal-color-picker {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .cal-color-option {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                border: 3px solid transparent;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .cal-color-option:hover {
                transform: scale(1.15);
            }

            .cal-color-option.selected {
                border-color: var(--text-main);
                box-shadow: 0 0 0 2px var(--bg-main), 0 0 0 4px var(--text-muted);
            }

            .cal-modal-actions {
                display: flex;
                justify-content: flex-end;
                gap: 0.75rem;
                margin-top: 1.5rem;
            }

            .cal-btn {
                padding: 0.6rem 1.4rem;
                border-radius: 10px;
                font-family: inherit;
                font-size: 0.85rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                border: none;
            }

            .cal-btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                color: #fff;
                box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
            }

            .cal-btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(30, 58, 138, 0.3);
            }

            .cal-btn-secondary {
                background: var(--bg-alt);
                color: var(--text-muted);
                border: 1px solid var(--card-border);
            }

            .cal-btn-secondary:hover {
                color: var(--text-main);
                border-color: var(--text-muted);
            }

            .cal-btn-danger {
                background: rgba(239, 68, 68, 0.08);
                color: #ef4444;
                border: 1px solid rgba(239, 68, 68, 0.2);
            }

            .cal-btn-danger:hover {
                background: #ef4444;
                color: #fff;
            }

            /* Day Events Popup */
            .cal-day-popup {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .cal-day-popup.active {
                opacity: 1;
                visibility: visible;
            }

            .cal-day-popup-card {
                background: var(--bg-main);
                border: 1px solid var(--card-border);
                border-radius: 20px;
                padding: 1.75rem;
                width: 90%;
                max-width: 380px;
                max-height: 70vh;
                overflow-y: auto;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
                transform: translateY(20px) scale(0.97);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .cal-day-popup.active .cal-day-popup-card {
                transform: translateY(0) scale(1);
            }

            .cal-day-popup-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.25rem;
            }

            .cal-day-popup-header h4 {
                color: var(--primary-color);
                font-size: 1.15rem;
                font-weight: 800;
            }

            .cal-day-popup-close {
                background: var(--bg-alt);
                border: 1px solid var(--card-border);
                color: var(--text-muted);
                width: 30px;
                height: 30px;
                border-radius: 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                transition: all 0.2s ease;
            }

            .cal-day-popup-close:hover {
                background: #ef4444;
                color: #fff;
                border-color: #ef4444;
            }

            .cal-event-item {
                background: var(--bg-alt);
                border: 1px solid var(--card-border);
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 0.75rem;
                transition: all 0.2s ease;
            }

            .cal-event-item:hover {
                border-color: var(--secondary-color);
                box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
            }

            .cal-event-item:last-child {
                margin-bottom: 0;
            }

            .cal-event-item-header {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                margin-bottom: 0.35rem;
            }

            .cal-event-item-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .cal-event-item-title {
                font-weight: 700;
                font-size: 0.95rem;
                color: var(--text-main);
            }

            .cal-event-item-time {
                font-size: 0.75rem;
                color: var(--text-muted);
                margin-left: auto;
                font-weight: 600;
            }

            .cal-event-item-desc {
                font-size: 0.8rem;
                color: var(--text-muted);
                line-height: 1.5;
                margin-bottom: 0.6rem;
                padding-left: 1.6rem;
            }

            .cal-event-item-actions {
                display: flex;
                gap: 0.5rem;
                padding-left: 1.6rem;
            }

            .cal-event-action-btn {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 0.3rem 0.7rem;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease;
                font-family: inherit;
            }

            .cal-event-edit-btn {
                background: rgba(59, 130, 246, 0.08);
                color: var(--secondary-color);
            }

            .cal-event-edit-btn:hover {
                background: var(--secondary-color);
                color: #fff;
            }

            .cal-event-delete-btn {
                background: rgba(239, 68, 68, 0.08);
                color: #ef4444;
            }

            .cal-event-delete-btn:hover {
                background: #ef4444;
                color: #fff;
            }

            .cal-no-events {
                text-align: center;
                color: var(--text-muted);
                font-size: 0.85rem;
                padding: 1.5rem 0;
            }

            .cal-day-popup-add-btn {
                width: 100%;
                margin-top: 1rem;
                padding: 0.6rem;
                border: 2px dashed var(--card-border);
                border-radius: 10px;
                background: transparent;
                color: var(--text-muted);
                font-family: inherit;
                font-size: 0.8rem;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.4rem;
            }

            .cal-day-popup-add-btn:hover {
                border-color: var(--primary-color);
                color: var(--primary-color);
            }

            /* Delete confirmation */
            .cal-confirm-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1100;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .cal-confirm-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .cal-confirm-card {
                background: var(--bg-main);
                border: 1px solid var(--card-border);
                border-radius: 16px;
                padding: 1.75rem;
                width: 90%;
                max-width: 340px;
                text-align: center;
                box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
                transform: scale(0.95);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .cal-confirm-overlay.active .cal-confirm-card {
                transform: scale(1);
            }

            .cal-confirm-card h4 {
                color: var(--text-main);
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }

            .cal-confirm-card p {
                color: var(--text-muted);
                font-size: 0.85rem;
                margin-bottom: 1.25rem;
                line-height: 1.5;
            }

            .cal-confirm-actions {
                display: flex;
                gap: 0.75rem;
                justify-content: center;
            }
        </style>

        <div class="card calendar-sidebar">
            <!-- Calendar Header -->
            <div class="calendar-header">
                <h3>Calendar</h3>
                <div class="calendar-nav">
                    <button class="calendar-nav-btn" id="cal-prev" title="Previous month">‹</button>
                    <span class="calendar-month-label" id="cal-month-label"></span>
                    <button class="calendar-nav-btn" id="cal-next" title="Next month">›</button>
                </div>
            </div>

            <!-- Weekday Headers -->
            <div class="calendar-weekdays">
                <div class="calendar-weekday">Sun</div>
                <div class="calendar-weekday">Mon</div>
                <div class="calendar-weekday">Tue</div>
                <div class="calendar-weekday">Wed</div>
                <div class="calendar-weekday">Thu</div>
                <div class="calendar-weekday">Fri</div>
                <div class="calendar-weekday">Sat</div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid" id="cal-grid"></div>

            <!-- Add Event Button -->
            <button class="calendar-add-btn" id="cal-add-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Event
            </button>
        </div>

        <!-- Create / Edit Event Modal -->
        <div class="cal-modal-overlay" id="cal-event-modal">
            <div class="cal-modal">
                <h3 id="cal-modal-title">New Event</h3>
                <div class="cal-modal-field">
                    <label for="cal-input-title">Title</label>
                    <input type="text" id="cal-input-title" placeholder="Event title" maxlength="255">
                </div>
                <div class="cal-modal-field">
                    <label for="cal-input-desc">Description</label>
                    <textarea id="cal-input-desc" placeholder="Optional description" rows="2"></textarea>
                </div>
                <div class="cal-modal-field">
                    <label for="cal-input-date">Date</label>
                    <input type="date" id="cal-input-date">
                </div>
                <div class="cal-modal-field">
                    <label for="cal-input-time">Time</label>
                    <input type="time" id="cal-input-time">
                </div>
                <div class="cal-modal-field">
                    <label>Color</label>
                    <div class="cal-color-picker" id="cal-color-picker">
                        <div class="cal-color-option selected" data-color="#3b82f6" style="background: #3b82f6;" title="Blue"></div>
                        <div class="cal-color-option" data-color="#1e3a8a" style="background: #1e3a8a;" title="Navy"></div>
                        <div class="cal-color-option" data-color="#f59e0b" style="background: #f59e0b;" title="Gold"></div>
                        <div class="cal-color-option" data-color="#10b981" style="background: #10b981;" title="Green"></div>
                        <div class="cal-color-option" data-color="#8b5cf6" style="background: #8b5cf6;" title="Purple"></div>
                        <div class="cal-color-option" data-color="#ef4444" style="background: #ef4444;" title="Red"></div>
                        <div class="cal-color-option" data-color="#ec4899" style="background: #ec4899;" title="Pink"></div>
                        <div class="cal-color-option" data-color="#0ea5e9" style="background: #0ea5e9;" title="Cyan"></div>
                    </div>
                </div>
                <div class="cal-modal-actions">
                    <button class="cal-btn cal-btn-secondary" id="cal-modal-cancel">Cancel</button>
                    <button class="cal-btn cal-btn-primary" id="cal-modal-save">Save</button>
                </div>
            </div>
        </div>

        <!-- Day Events Popup -->
        <div class="cal-day-popup" id="cal-day-popup">
            <div class="cal-day-popup-card">
                <div class="cal-day-popup-header">
                    <h4 id="cal-day-popup-title"></h4>
                    <button class="cal-day-popup-close" id="cal-day-popup-close">×</button>
                </div>
                <div id="cal-day-popup-events"></div>
                <button class="cal-day-popup-add-btn" id="cal-day-popup-add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add event on this day
                </button>
            </div>
        </div>

        <!-- Delete Confirmation -->
        <div class="cal-confirm-overlay" id="cal-confirm-delete">
            <div class="cal-confirm-card">
                <h4>Delete Event?</h4>
                <p>This action cannot be undone.</p>
                <div class="cal-confirm-actions">
                    <button class="cal-btn cal-btn-secondary" id="cal-confirm-no">Cancel</button>
                    <button class="cal-btn cal-btn-danger" id="cal-confirm-yes">Delete</button>
                </div>
            </div>
        </div>

    </main>

    <!-- Easter Egg Overlay -->
    <div id="logo-easter-egg" class="easter-egg-overlay">
        <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="easter-egg-logo">
        <div class="easter-egg-text">DESIGNED AND DEVELOPED BY LCBA SMIS</div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notesArea = document.getElementById('quick-notes');
            let timeout = null;

            if (notesArea) {
                notesArea.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        saveNotes();
                    }, 1000); // Save after 1 second of inactivity
                });
            }

            function saveNotes() {
                const notes = notesArea.value;
                const indicator = document.getElementById('save-indicator');
                
                if (!indicator) return;

                indicator.textContent = 'Saving...';
                indicator.style.opacity = '1';

                fetch('{{ route("dashboard.notes") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ notes: notes })
                })
                .then(response => response.json())
                .then(data => {
                    indicator.textContent = 'Saved';
                    setTimeout(() => {
                        indicator.style.opacity = '0';
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error saving notes:', error);
                    indicator.textContent = 'Error';
                    indicator.style.color = '#ef4444';
                });
            }

            // Easter Egg Logic
            let logoClicks = 0;
            let lastLogoClick = 0;
            const navLogo = document.querySelector('.dashboard-nav-logo');
            const easterEgg = document.getElementById('logo-easter-egg');

            if (navLogo) {
                navLogo.style.cursor = 'pointer';
                navLogo.addEventListener('click', (e) => {
                    e.preventDefault();
                    const now = Date.now();
                    if (now - lastLogoClick < 600) {
                        logoClicks++;
                    } else {
                        logoClicks = 1;
                    }
                    lastLogoClick = now;

                    if (logoClicks >= 3) {
                        if (easterEgg) easterEgg.classList.add('active');
                        logoClicks = 0;
                    }
                });
            }

            if (easterEgg) {
                easterEgg.addEventListener('click', () => {
                    easterEgg.classList.remove('active');
                });
            }
        });
    </script>

    <!-- Calendar Script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let eventsCache = {};        // { 'YYYY-MM-DD': [event, ...] }
        let editingEventId = null;   // null = create mode, id = edit mode
        let deletingEventId = null;
        let selectedColor = '#3b82f6';
        let activeDayPopupDate = null;

        // DOM refs
        const grid = document.getElementById('cal-grid');
        const monthLabel = document.getElementById('cal-month-label');
        const prevBtn = document.getElementById('cal-prev');
        const nextBtn = document.getElementById('cal-next');
        const addBtn = document.getElementById('cal-add-btn');

        const eventModal = document.getElementById('cal-event-modal');
        const modalTitle = document.getElementById('cal-modal-title');
        const inputTitle = document.getElementById('cal-input-title');
        const inputDesc = document.getElementById('cal-input-desc');
        const inputDate = document.getElementById('cal-input-date');
        const inputTime = document.getElementById('cal-input-time');
        const colorPicker = document.getElementById('cal-color-picker');
        const modalCancel = document.getElementById('cal-modal-cancel');
        const modalSave = document.getElementById('cal-modal-save');

        const dayPopup = document.getElementById('cal-day-popup');
        const dayPopupTitle = document.getElementById('cal-day-popup-title');
        const dayPopupEvents = document.getElementById('cal-day-popup-events');
        const dayPopupClose = document.getElementById('cal-day-popup-close');
        const dayPopupAdd = document.getElementById('cal-day-popup-add');

        const confirmOverlay = document.getElementById('cal-confirm-delete');
        const confirmYes = document.getElementById('cal-confirm-yes');
        const confirmNo = document.getElementById('cal-confirm-no');

        // ── Helpers ──
        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function dateKey(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        function formatTime(t) {
            if (!t) return '';
            const [h, m] = t.split(':');
            const hr = parseInt(h);
            const ampm = hr >= 12 ? 'PM' : 'AM';
            const h12 = hr % 12 || 12;
            return `${h12}:${m} ${ampm}`;
        }

        function formatDateNice(dateStr) {
            const d = new Date(dateStr + 'T00:00:00');
            return `${MONTHS[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
        }

        // ── Fetch Events ──
        async function fetchEvents() {
            try {
                const res = await fetch(`{{ route('dashboard.events') }}?month=${currentMonth + 1}&year=${currentYear}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                eventsCache = {};
                data.forEach(ev => {
                    const key = ev.event_date;
                    if (!eventsCache[key]) eventsCache[key] = [];
                    eventsCache[key].push(ev);
                });
                renderGrid();
            } catch (err) {
                console.error('Failed to fetch events:', err);
            }
        }

        // ── Render Calendar Grid ──
        function renderGrid() {
            monthLabel.textContent = `${MONTHS[currentMonth]} ${currentYear}`;
            grid.innerHTML = '';

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrev = new Date(currentYear, currentMonth, 0).getDate();

            const today = new Date();
            const todayKey = dateKey(today.getFullYear(), today.getMonth(), today.getDate());

            // Previous month trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                const d = daysInPrev - i;
                const cell = createDayCell(d, true, null);
                grid.appendChild(cell);
            }

            // Current month days
            for (let d = 1; d <= daysInMonth; d++) {
                const key = dateKey(currentYear, currentMonth, d);
                const isToday = key === todayKey;
                const cell = createDayCell(d, false, key, isToday);
                grid.appendChild(cell);
            }

            // Next month leading days
            const totalCells = firstDay + daysInMonth;
            const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let d = 1; d <= remaining; d++) {
                const cell = createDayCell(d, true, null);
                grid.appendChild(cell);
            }
        }

        function createDayCell(dayNum, isOther, dateKeyStr, isToday = false) {
            const cell = document.createElement('div');
            cell.className = 'calendar-day';
            if (isOther) cell.classList.add('other-month');
            if (isToday) cell.classList.add('today');

            const num = document.createElement('div');
            num.className = 'calendar-day-number';
            num.textContent = dayNum;
            cell.appendChild(num);

            if (dateKeyStr && eventsCache[dateKeyStr]) {
                const dots = document.createElement('div');
                dots.className = 'calendar-event-dots';
                eventsCache[dateKeyStr].forEach(ev => {
                    const dot = document.createElement('div');
                    dot.className = 'calendar-event-dot';
                    dot.style.background = ev.color || '#3b82f6';
                    dots.appendChild(dot);
                });
                cell.appendChild(dots);
            }

            if (!isOther && dateKeyStr) {
                cell.addEventListener('click', () => openDayPopup(dateKeyStr));
            }

            return cell;
        }

        // ── Month Navigation ──
        prevBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            fetchEvents();
        });

        nextBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            fetchEvents();
        });

        // ── Add Event Button ──
        addBtn.addEventListener('click', () => {
            openEventModal(null, dateKey(currentYear, currentMonth, new Date().getDate() <= new Date(currentYear, currentMonth + 1, 0).getDate() ? new Date().getDate() : 1));
        });

        // ── Event Modal ──
        function openEventModal(event, prefillDate) {
            editingEventId = event ? event.id : null;
            modalTitle.textContent = event ? 'Edit Event' : 'New Event';

            inputTitle.value = event ? event.title : '';
            inputDesc.value = event ? (event.description || '') : '';
            inputDate.value = event ? event.event_date : (prefillDate || '');
            inputTime.value = event ? (event.event_time ? event.event_time.substring(0, 5) : '') : '';
            selectedColor = event ? (event.color || '#3b82f6') : '#3b82f6';

            colorPicker.querySelectorAll('.cal-color-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.color === selectedColor);
            });

            eventModal.classList.add('active');
            setTimeout(() => inputTitle.focus(), 100);
        }

        function closeEventModal() {
            eventModal.classList.remove('active');
            editingEventId = null;
        }

        modalCancel.addEventListener('click', closeEventModal);
        eventModal.addEventListener('click', (e) => { if (e.target === eventModal) closeEventModal(); });

        // Color picker
        colorPicker.addEventListener('click', (e) => {
            const opt = e.target.closest('.cal-color-option');
            if (!opt) return;
            selectedColor = opt.dataset.color;
            colorPicker.querySelectorAll('.cal-color-option').forEach(el => {
                el.classList.toggle('selected', el === opt);
            });
        });

        // Save event
        modalSave.addEventListener('click', async () => {
            const title = inputTitle.value.trim();
            if (!title) { inputTitle.focus(); return; }
            const dateVal = inputDate.value;
            if (!dateVal) { inputDate.focus(); return; }

            const payload = {
                title: title,
                description: inputDesc.value.trim() || null,
                event_date: dateVal,
                event_time: inputTime.value || null,
                color: selectedColor,
            };

            try {
                let url, method;
                if (editingEventId) {
                    url = `{{ url('/dashboard/events') }}/${editingEventId}`;
                    method = 'PUT';
                } else {
                    url = `{{ route('dashboard.events.store') }}`;
                    method = 'POST';
                }

                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (!res.ok) throw new Error('Save failed');

                closeEventModal();
                await fetchEvents();

                // Refresh day popup if open
                if (activeDayPopupDate) {
                    openDayPopup(activeDayPopupDate);
                }
            } catch (err) {
                console.error('Error saving event:', err);
                alert('Failed to save event. Please try again.');
            }
        });

        // ── Day Events Popup ──
        function openDayPopup(dateKeyStr) {
            activeDayPopupDate = dateKeyStr;
            const events = eventsCache[dateKeyStr] || [];
            dayPopupTitle.textContent = formatDateNice(dateKeyStr);

            if (events.length === 0) {
                dayPopupEvents.innerHTML = '<div class="cal-no-events">No events on this day</div>';
            } else {
                dayPopupEvents.innerHTML = events.map(ev => `
                    <div class="cal-event-item">
                        <div class="cal-event-item-header">
                            <div class="cal-event-item-dot" style="background: ${ev.color || '#3b82f6'}"></div>
                            <span class="cal-event-item-title">${escHtml(ev.title)}</span>
                            ${ev.event_time ? `<span class="cal-event-item-time">${formatTime(ev.event_time)}</span>` : ''}
                        </div>
                        ${ev.description ? `<div class="cal-event-item-desc">${escHtml(ev.description)}</div>` : ''}
                        <div class="cal-event-item-actions">
                            <button class="cal-event-action-btn cal-event-edit-btn" data-id="${ev.id}">Edit</button>
                            <button class="cal-event-action-btn cal-event-delete-btn" data-id="${ev.id}">Delete</button>
                        </div>
                    </div>
                `).join('');
            }

            dayPopup.classList.add('active');
        }

        function closeDayPopup() {
            dayPopup.classList.remove('active');
            activeDayPopupDate = null;
        }

        dayPopupClose.addEventListener('click', closeDayPopup);
        dayPopup.addEventListener('click', (e) => { if (e.target === dayPopup) closeDayPopup(); });

        // Add event from day popup
        dayPopupAdd.addEventListener('click', () => {
            const dateStr = activeDayPopupDate;
            closeDayPopup();
            openEventModal(null, dateStr);
        });

        // Edit / Delete from day popup
        dayPopupEvents.addEventListener('click', (e) => {
            const editBtn = e.target.closest('.cal-event-edit-btn');
            const deleteBtn = e.target.closest('.cal-event-delete-btn');

            if (editBtn) {
                const evId = parseInt(editBtn.dataset.id);
                const ev = findEventById(evId);
                if (ev) {
                    closeDayPopup();
                    openEventModal(ev, null);
                }
            }

            if (deleteBtn) {
                deletingEventId = parseInt(deleteBtn.dataset.id);
                confirmOverlay.classList.add('active');
            }
        });

        function findEventById(id) {
            for (const key in eventsCache) {
                const found = eventsCache[key].find(e => e.id === id);
                if (found) return found;
            }
            return null;
        }

        function escHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        // ── Delete Confirmation ──
        confirmNo.addEventListener('click', () => {
            confirmOverlay.classList.remove('active');
            deletingEventId = null;
        });

        confirmOverlay.addEventListener('click', (e) => {
            if (e.target === confirmOverlay) {
                confirmOverlay.classList.remove('active');
                deletingEventId = null;
            }
        });

        confirmYes.addEventListener('click', async () => {
            if (!deletingEventId) return;
            try {
                const res = await fetch(`{{ url('/dashboard/events') }}/${deletingEventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                });
                if (!res.ok) throw new Error('Delete failed');

                confirmOverlay.classList.remove('active');
                deletingEventId = null;
                await fetchEvents();

                // Refresh day popup if still open
                if (activeDayPopupDate) {
                    openDayPopup(activeDayPopupDate);
                }
            } catch (err) {
                console.error('Error deleting event:', err);
                alert('Failed to delete event. Please try again.');
            }
        });

        // ── Init ──
        fetchEvents();
    });
    </script>
</body>
</html>
