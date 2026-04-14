/**
 * Learn Page — Smooth Scroll
 *
 * Handles smooth-scroll behavior for the hero CTA button.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */
(function () {
  "use strict";

  const cta = document.querySelector(".learn-hero__cta");
  if (!cta) return;

  cta.addEventListener("click", function (e) {
    const target = document.querySelector(this.getAttribute("href"));
    if (!target) return;

    e.preventDefault();

    // Account for fixed header height plus a small gap so content
    // isn't flush against the bottom edge of the nav bar.
    const header = document.querySelector("header");
    const headerHeight = header ? header.offsetHeight : 0;
    const gap = 32;

    const targetPosition =
      target.getBoundingClientRect().top +
      window.pageYOffset -
      headerHeight -
      gap;

    window.scrollTo({
      top: targetPosition,
      behavior: "smooth",
    });
  });
})();
