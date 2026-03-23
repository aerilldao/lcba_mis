<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head', ['title' => 'LCBA - Dashboard'])

</head>
<body style="align-items: flex-start; background-color: var(--bg-alt);">
<body class="dashboard-body">
    @include('partials.navbar-dashboard')

    <!-- Main Content -->
    <main class="dashboard-content">
        
        <!-- Left Column -->
        <div class="dashboard-left-col">
            
            <!-- Quick Notes -->
            <div class="card dashboard-main-area">
                <h2 class="notes-heading">
                    Quick Notes
                    <span id="save-indicator">Saving...</span>
                </h2>
                <textarea id="quick-notes" placeholder="Type your notes here...">{{ auth()->user()->quick_notes }}</textarea>
            </div>

            <!-- Bottom Row: Functions & Detailed Stats -->
            <div class="bottom-row-stats">
                
                <!-- Functions & General Stats -->
                <div class="card functions-card">
                    <a href="{{ route('checklist') }}" class="btn-login">Open Checklist</a>
                    
                    <div class="stat-inner-grid">
                        <div class="stat-inner-card basic">
                            <h4>Basic Education</h4>
                            <span>{{ $totalBasic }}</span>
                            <a href="{{ route('basic_education_records') }}" class="btn-view-records basic">View Records</a>
                        </div>

                        <div class="stat-inner-card collegiate">
                            <h4>College &amp; Graduate</h4>
                            <span>{{ $totalCollege }}</span>
                            <a href="{{ route('collegiate_records') }}" class="btn-view-records collegiate">View Records</a>
                        </div>
                    </div>
                </div>

                <!-- Detailed Counters -->
                <div class="card enrollment-breakdown-card">
                    <h3 class="breakdown-title">Enrollment Breakdown</h3>
                    
                    @php
                        $totalAll = ($totalBasic + $totalCollege) ?: 1; 
                    @endphp
                    <div class="breakdown-grid">
                        <div class="breakdown-item">
                            <span class="count kinder">{{ $kinderElem }}</span>
                            <span class="label">Kinder to Elem.</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar kinder" style="width: {{ ($kinderElem / $totalAll) * 100 }}%;"></div>
                            </div>
                        </div>
                        
                        <div class="breakdown-item">
                            <span class="count junior">{{ $juniorHigh }}</span>
                            <span class="label">Junior High</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar junior" style="width: {{ ($juniorHigh / $totalAll) * 100 }}%;"></div>
                            </div>
                        </div>
                        
                        <div class="breakdown-item">
                            <span class="count senior">{{ $seniorHigh }}</span>
                            <span class="label">Senior High</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar senior" style="width: {{ ($seniorHigh / $totalAll) * 100 }}%;"></div>
                            </div>
                        </div>

                        <div class="breakdown-item">
                            <span class="count college">{{ $college }}</span>
                            <span class="label">College</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar college" style="width: {{ ($college / $totalAll) * 100 }}%;"></div>
                            </div>
                        </div>
                        
                        <div class="breakdown-item graduate-item">
                            <span class="count graduate">{{ $graduateStudies }}</span>
                            <span class="label">Graduate Studies</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar graduate" style="width: {{ ($graduateStudies / $totalAll) * 100 }}%;"></div>
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
