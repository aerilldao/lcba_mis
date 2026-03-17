<!-- Easter Egg Overlay -->
    <div id="logo-easter-egg" class="easter-egg-overlay">
        <img src="{{ asset('images/LCBA LOGO VECTOR.png') }}" alt="LCBA Logo" class="easter-egg-logo">
        <div class="easter-egg-text">DESIGNED AND DEVELOPED BY LCBA SMIS</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
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