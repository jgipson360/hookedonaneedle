/**
 * Shop Page Interactions
 *
 * Handles view toggle (grid/list) via URL parameter updates.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */
document.addEventListener('DOMContentLoaded', function () {
    var grid = document.getElementById('product-grid');
    if (!grid) return;

    document.querySelectorAll('[data-view]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var view = this.dataset.view;
            var url = new URL(window.location);
            url.searchParams.set('view', view);
            window.location.href = url.toString();
        });
    });
});
