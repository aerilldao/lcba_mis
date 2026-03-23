<nav class="checklist-nav">
    <div class="checklist-nav-left">
        <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="checklist-nav-logo">
        <h1>{{ $title ?? 'LCBA' }}</h1>
    </div>
    <div class="nav-actions">
        <button onclick="toggleDarkMode()" class="theme-toggle-nav" title="Toggle Night Mode">
            <svg xmlns="http://www.w3.org/2000/svg" class="theme-icon-sun" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="theme-icon-moon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
        </button>
        @if(isset($backRoute) && isset($backText))
        <a href="{{ $backRoute }}" class="btn-back" style="text-decoration: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            {{ $backText }}
        </a>
        @endif

        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-login" style="padding: 0.5rem 1.5rem; font-size: 0.9rem;">Log Out</button>
        </form>
    </div>
</nav>
