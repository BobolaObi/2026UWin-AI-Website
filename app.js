(() => {
  const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches;
  if (prefersReducedMotion) return;

  const onReady = () => {
    // Stagger any reveal-marked elements.
    const revealNodes = Array.from(document.querySelectorAll('[data-reveal]'));
    revealNodes.forEach((node, index) => {
      if (!node.style.getPropertyValue('--delay')) {
        node.style.setProperty('--delay', `${index * 70}ms`);
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

