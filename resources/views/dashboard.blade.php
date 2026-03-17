<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head', ['title' => 'LCBA - Dashboard'])
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
            color: var(--primary-text-heading);
            letter-spacing: 0.05em;
            margin: 0;
        }

        .dashboard-content {
            margin-top: 100px;
            padding: 2rem;
            width: 100%;
            max-width: 1540px;
            display: grid;
            grid-template-columns: 1fr 480px;
            gap: 2rem;
            align-items: stretch; /* Match height of columns */
        }

        @media (max-width: 1280px) {
            .dashboard-content {
                max-width: 100%;
                grid-template-columns: 1fr 400px;
            }
        }

        @media (max-width: 1200px) {
            .dashboard-content {
                grid-template-columns: 1fr;
                padding: 1rem;
                margin-top: 80px;
            }
            .dashboard-nav {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-nav h1 {
                font-size: 1.1rem;
            }
            .dashboard-nav-logo {
                height: 35px;
            }
            .dashboard-content {
                gap: 1.5rem;
            }
            .stat-inner-card span {
                font-size: 1.75rem !important;
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
    @include('partials.navbar-dashboard')

    <!-- Main Content -->
    <main class="dashboard-content">
        
        <!-- Left Column -->
        <div class="dashboard-left-col" style="display: flex; flex-direction: column; gap: 2rem;">
            
            <style>
                @media (min-width: 1201px) {
                    .dashboard-left-col {
                        position: relative; /* Remove sticky to allow natural stretch */
                        display: flex;
                        flex-direction: column;
                    }
                }
                @media (max-width: 600px) {
                    .bottom-row-stats {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>
            
            <!-- Quick Notes -->
            <div class="card dashboard-main-area" style="width: 100%; max-width: none; padding: 2rem; flex: 1; display: flex; flex-direction: column;">
                <h2 style="color: var(--primary-text-heading); margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    Quick Notes
                    <span id="save-indicator" style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted); opacity: 0; transition: opacity 0.3s;">Saving...</span>
                </h2>
                <textarea id="quick-notes" style="flex: 1; min-height: 150px; width: 100%; border: none; resize: none; outline: none; background: transparent; font-family: inherit; font-size: 1.05rem; color: var(--text-main); line-height: 1.6; position: relative; z-index: 1;" placeholder="Type your notes here...">{{ auth()->user()->quick_notes }}</textarea>
            </div>

            <!-- Bottom Row: Functions & Detailed Stats -->
            <div class="bottom-row-stats" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
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
                <div class="card" style="width: 100%; max-width: none; padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; position: relative; z-index: 5;">
                    <a href="{{ route('checklist') }}" class="btn-login" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; width: 100%; height: 62px; font-size: 1.1rem; border-radius: 14px; position: relative; z-index: 10; font-weight: 700;">Open Checklist</a>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div class="stat-inner-card">
                            <h4 style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; font-weight: 800; margin-bottom: 0.25rem;">Basic Education</h4>
                            <span style="font-size: 2.5rem; font-weight: 800; color: var(--primary-text-heading); line-height: 1;">0</span>
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
                <div class="card" style="width: 100%; max-width: none; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; align-items: center; text-align: center;">
                    <h3 style="color: var(--primary-text-heading); font-size: 1.15rem; margin-bottom: 0.5rem;">Enrollment Breakdown</h3>
                    
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

        @include('partials.sidebar-calendar')

    @include('partials.easter-egg')
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
        });
    </script>

    
</body>
</html>
