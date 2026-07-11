document.addEventListener('DOMContentLoaded', () => {
  const cartCountEl = document.getElementById('cartCount');

  document.querySelectorAll('.card form').forEach(form => {
    form.addEventListener('submit', () => {
      if (cartCountEl) {
        cartCountEl.textContent = (parseInt(cartCountEl.textContent, 10) || 0) + 1;
      }
    });
  });

  // ---------- Off-canvas mobile menu ----------
  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  const menuBackdrop = document.getElementById('menuBackdrop');
  const menuClose = document.getElementById('menuClose');

  function openMenu() {
    mobileMenu.classList.add('is-open');
    menuBackdrop.classList.add('is-open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    menuToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    mobileMenu.classList.remove('is-open');
    menuBackdrop.classList.remove('is-open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    menuToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (menuToggle && mobileMenu && menuBackdrop) {
    menuToggle.addEventListener('click', openMenu);
    menuClose.addEventListener('click', closeMenu);
    menuBackdrop.addEventListener('click', closeMenu);
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeMenu();
    });
  }

  // ---------- Flash-sale countdown ----------
  const countdown = document.getElementById('flashCountdown');
  if (countdown) {
    const endsAt = new Date(countdown.dataset.endsAt).getTime();
    const circumference = 138;

    const numH = document.getElementById('numH');
    const numM = document.getElementById('numM');
    const numS = document.getElementById('numS');
    const ringH = document.getElementById('ringH');
    const ringM = document.getElementById('ringM');
    const ringS = document.getElementById('ringS');

    function tick() {
      const diff = Math.max(0, Math.floor((endsAt - Date.now()) / 1000));
      const h = Math.floor(diff / 3600);
      const m = Math.floor((diff % 3600) / 60);
      const s = diff % 60;

      numH.textContent = String(h).padStart(2, '0');
      numM.textContent = String(m).padStart(2, '0');
      numS.textContent = String(s).padStart(2, '0');

      ringH.style.strokeDashoffset = circumference - (Math.min(h, 23) / 23) * circumference;
      ringM.style.strokeDashoffset = circumference - (m / 59) * circumference;
      ringS.style.strokeDashoffset = circumference - (s / 59) * circumference;

      if (diff <= 0) clearInterval(interval);
    }

    tick();
    const interval = setInterval(tick, 1000);
  }
});
