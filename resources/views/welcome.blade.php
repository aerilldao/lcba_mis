<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head', ['title' => 'LCBA - Selection Portal'])
</head>
    <body class="landing-page-body">
    <div class="background-animation"></div>
    
    <button onclick="toggleDarkMode()" class="theme-toggle-btn" title="Toggle Night Mode">
        <svg xmlns="http://www.w3.org/2000/svg" class="theme-icon-sun" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
        <svg xmlns="http://www.w3.org/2000/svg" class="theme-icon-moon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
    </button>

    <div class="container">
        <header class="header-container fade-in">
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="header-logo">
            <h1>LAGUNA COLLEGE <br>OF BUSINESS & ARTS</h1>
        </header>

        <main class="selection-container fade-in-delay-2">
            <a href="#guidance" class="card guidance-card" id="card-guidance">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h2>Guidance</h2>
                <div class="card-action">
                    <span>Enter Portal</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </div>
            </a>
            
            <a href="#registrar" class="card registrar-card" id="card-registrar">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-check">
                        <path d="M8 3H2v15h7c1.7 0 3 1.3 3 3V7c0-2.2-1.8-4-4-4Z"/>
                        <path d="m16 12 2 2 4-4"/>
                        <path d="M22 6V3h-6c-2.2 0-4 1.8-4 4v14c0-1.7 1.3-3 3-3h7v-2.3"/>
                    </svg>
                </div>
                <h2>Registrar</h2>
                <div class="card-action">
                    <span>Enter Portal</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </main>
    </div>
    <!-- Login Modal section -->
    @include('auth.login')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const registrarCard = document.getElementById('card-registrar');
            const guidanceCard = document.getElementById('card-guidance');
            const loginModal = document.getElementById('login-modal');
            const loginTitle = document.getElementById('login-title');
            const loginSubtitle = document.getElementById('login-subtitle');
            const btnBack = document.getElementById('btn-back');

            registrarCard.addEventListener('click', (e) => {
                e.preventDefault();
                loginTitle.textContent = 'Registrar Login';
                loginSubtitle.textContent = 'Please enter your credentials to safely access the module.';
                loginModal.classList.add('visible');
            });

            guidanceCard.addEventListener('click', (e) => {
                e.preventDefault();
                loginTitle.textContent = 'Guidance Login';
                loginSubtitle.textContent = 'Guidance module login is currently being integrated from an external project.';
                loginModal.classList.add('visible');
            });

            btnBack.addEventListener('click', () => {
                loginModal.classList.remove('visible');
            });
            
            // Optional: close modal on clicking overlay background
            loginModal.addEventListener('click', (e) => {
                if(e.target === loginModal) {
                    loginModal.classList.remove('visible');
                }
            });

            @if ($errors->any())
                // Reopen the modal automatically if there are login errors
                loginModal.classList.add('visible');
            @endif
        });
    </script>
</body>
</html>
