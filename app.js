(() => {
  const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches;
  if (prefersReducedMotion) return;

  const onReady = () => {
    // Stagger any reveal-marked elements.
    const isLeadersPage = document.body.classList.contains('leaders-page');
    const revealNodes = Array.from(document.querySelectorAll('[data-reveal]'));
    const delayStepMs = isLeadersPage ? 35 : 70;
    const maxDelayMs = isLeadersPage ? 500 : 1400;
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
