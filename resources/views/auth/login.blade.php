<div class="login-modal-overlay" id="login-modal">
    <div class="login-card">
        <h2 id="login-title">Registrar Login</h2>
        <p id="login-subtitle">Please enter your credentials to safely access the module.</p>
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
