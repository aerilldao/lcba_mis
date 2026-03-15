<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCBA - Selection Portal</title>
    <meta name="description" content="Welcome to the Laguna College of Business & Arts Portal. Select Guidance or Registrar to continue.">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dark-mode.js') }}"></script>
</head>
<body>
    <div class="background-animation"></div>
    <div class="container">
        <header class="header-container fade-in" style="position: relative;">
            <div style="position: absolute; top: -20px; right: 0;">
                 
            </div>
            <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="header-logo">
            <h1>LAGUNA COLLEGE <br>OF BUSINESS & ARTS</h1>
        </header>

        <main class="selection-container fade-in-delay-2">
            <a href="#guidance" class="card guidance-card" id="card-guidance">
                <div class="card-icon">
                    <!-- SVG icon for guidance -->
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
                    <!-- SVG icon for registrar -->
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
    <div class="login-modal-overlay" id="login-modal">
        <div class="login-card">
            <h2>Registrar Login</h2>
            <p>Please enter your credentials to safely access the module.</p>
            <form id="registrar-login-form" method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.75rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="input-group">
                    <label for="email">Email / Username</label>
                    <input type="text" id="email" name="email" required placeholder="EMAIL" value="{{ old('email') }}">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-back" id="btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        Back
                    </button>
                    <button type="submit" class="btn-login">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const registrarCard = document.getElementById('card-registrar');
            const loginModal = document.getElementById('login-modal');
            const btnBack = document.getElementById('btn-back');

            registrarCard.addEventListener('click', (e) => {
                e.preventDefault();
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
