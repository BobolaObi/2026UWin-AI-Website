(() => {
  const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches;
  if (prefersReducedMotion) return;

  const onReady = () => {
    const navToggle = document.querySelector('[data-nav-toggle]');
    const mobileNav = document.getElementById('mobileNav');
    const navCloseButtons = Array.from(document.querySelectorAll('[data-nav-close]'));

    const setNavOpen = (open) => {
      document.body.classList.toggle('nav-open', open);
      if (navToggle) navToggle.setAttribute('aria-expanded', String(open));
      if (mobileNav) mobileNav.hidden = !open;
    };

    if (navToggle && mobileNav) {
      navToggle.addEventListener('click', () => {
        setNavOpen(!document.body.classList.contains('nav-open'));
      });

      navCloseButtons.forEach((btn) => {
        btn.addEventListener('click', () => setNavOpen(false));
      });

      mobileNav.addEventListener('click', (e) => {
        const target = e.target;
        if (!(target instanceof Element)) return;
        if (target.closest('a')) setNavOpen(false);
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setNavOpen(false);
      });
    }

    // Stagger any reveal-marked elements.
    const isLeadersPage = document.body.classList.contains('leaders-page');
    const revealNodes = Array.from(document.querySelectorAll('[data-reveal]'));
    const delayStepMs = isLeadersPage ? 20 : 70;
    const maxDelayMs = isLeadersPage ? 250 : 1400;
    revealNodes.forEach((node, index) => {
      if (!node.style.getPropertyValue('--delay')) {
        const delay = Math.min(index * delayStepMs, maxDelayMs);
        node.style.setProperty('--delay', `${delay}ms`);
      }
    });

    // Trigger the CSS entrance state after first paint.
    requestAnimationFrame(() => {
      document.body.classList.add('page-enter');
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady, { once: true });
  } else {
    onReady();
  }
})();
