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
            grid-template-columns: 1fr 350px;
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
        <div class="card dashboard-sidebar" style="padding: 1.5rem; width: 100%; min-width: 0; position: sticky; top: 110px; height: calc(100vh - 140px); display: flex; flex-direction: column;">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">Upcoming Events</h3>
            <div style="flex: 1; position: relative; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); overflow: hidden;">
                <!-- Integrating User's Google Calendar -->
                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FManila&showPrint=0&src=YS5kYW9AbGNiYS5lZHUucGg&src=ZS52aXNjb0BsY2JhLmVkdS5waA&src=ZW4ucGhpbGlwcGluZXMjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039be5&color=%23e4c441&color=%230b8043" style="border:solid 1px #777" width="300" height="535" frameborder="0" scrolling="no"></iframe>

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
</body>
</html>
