<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </style>
</head>
<body style="align-items: flex-start; background-color: #f8fafc;">
    <!-- Navigation Bar -->
    <nav class="dashboard-nav">
        <div class="dashboard-nav-left">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="dashboard-nav-logo">
            <h1>DASHBOARD</h1>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
        </form>
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
                
                <!-- Functions & General Stats -->
                <div class="card" style="width: 100%; padding: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                    <a href="{{ route('checklist') }}" target="_blank" class="btn-login" style="text-align: center; text-decoration: none; display: block; width: 100%;">Open Checklist</a>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="background: rgba(59, 130, 246, 0.05); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.1); text-align: center;">
                            <h4 style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Basic Education</h4>
                            <span style="font-size: 2.2rem; font-weight: 800; color: var(--primary-color);">0</span>
                        </div>
                        
                        <div style="background: rgba(245, 158, 11, 0.05); padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(245, 158, 11, 0.1); text-align: center;">
                            <h4 style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">College & Graduate</h4>
                            <span style="font-size: 2.2rem; font-weight: 800; color: var(--accent-color);">0</span>
                        </div>
                    </div>
                </div>

                <!-- Detailed Counters -->
                <div class="card" style="width: 100%; padding: 2rem; display: flex; flex-direction: column; gap: 1rem;">
                    <h3 style="color: var(--primary-color); font-size: 1.15rem; margin-bottom: 0.5rem;"> Detailed Enrollment breakdown</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; flex: 1;">
                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #10b981;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Kinder to Elem.</span>
                            <div style="width: 100%; height: 6px; background: rgba(16, 185, 129, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #10b981; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 0.5rem; display: flex; flex-direction: column;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #3b82f6;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Junior High</span>
                            <div style="width: 100%; height: 6px; background: rgba(59, 130, 246, 0.1); border-radius: 4px; overflow: hidden;">
                                <div style="width: 0%; height: 100%; background: #3b82f6; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding-top: 0.5rem; display: flex; flex-direction: column;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #8b5cf6;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Senior High</span>
                            <div style="width: 100%; height: 6px; background: rgba(139, 92, 246, 0.1); border-radius: 4px; overflow: hidden; margin-top: auto;">
                                <div style="width: 0%; height: 100%; background: #8b5cf6; border-radius: 4px; transition: width 1s ease;"></div>
                            </div>
                        </div>
                        
                        <div style="text-align: center; padding-top: 0.5rem; display: flex; flex-direction: column;">
                            <span style="display: block; font-size: 1.75rem; font-weight: 700; color: #f59e0b;">0</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">Graduate Studies</span>
                            <div style="width: 100%; height: 6px; background: rgba(245, 158, 11, 0.1); border-radius: 4px; overflow: hidden; margin-top: auto;">
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
    <script>
        const notesArea = document.getElementById('quick-notes');
        let timeout = null;

        notesArea.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                saveNotes();
            }, 1000); // Save after 1 second of inactivity
        });

        function saveNotes() {
            const notes = notesArea.value;
            const indicator = document.getElementById('save-indicator');
            
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
    </script>
</body>
</html>
