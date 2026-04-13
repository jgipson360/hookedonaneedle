<?php
/**
 * Pagination Component
 *
 * Renders numbered page navigation with previous/next arrows.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;
$total_pages = (int) $wp_query->max_num_pages;
$current_page = max(1, get_query_var('paged'));

if ($total_pages <= 1) {
    return;
}
?>

<nav class="flex items-center justify-center space-x-3 mt-20" aria-label="Product pagination">
    <!-- Previous Arrow -->
    <?php if ($current_page > 1) : ?>
        <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>"
           class="w-10 h-10 flex items-center justify-center rounded-full border border-pink-100 dark:border-slate-700 text-slate-400 hover:text-primary hover:border-primary transition-colors"
           aria-label="Previous page">
            <span class="material-icons-outlined text-lg">chevron_left</span>
        </a>
    <?php else : ?>
        <span class="w-10 h-10 flex items-center justify-center rounded-full border border-pink-100/50 dark:border-slate-800 text-slate-300 dark:text-slate-600 cursor-not-allowed"
              aria-label="Previous page (disabled)" aria-disabled="true">
            <span class="material-icons-outlined text-lg">chevron_left</span>
        </span>
    <?php endif; ?>

    <!-- Page Numbers -->
    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <?php if ($i === $current_page) : ?>
            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white font-bold text-xs font-sans"
                  aria-label="Page <?php echo $i; ?>, current page" aria-current="page">
                <?php echo $i; ?>
            </span>
        <?php else : ?>
            <a href="<?php echo esc_url(get_pagenum_link($i)); ?>"
               class="w-10 h-10 flex items-center justify-center rounded-full text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-primary transition-colors font-sans"
               aria-label="Page <?php echo $i; ?>">
                <?php echo $i; ?>
            </a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- Next Arrow -->
    <?php if ($current_page < $total_pages) : ?>
        <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>"
           class="w-10 h-10 flex items-center justify-center rounded-full border border-pink-100 dark:border-slate-700 text-slate-400 hover:text-primary hover:border-primary transition-colors"
           aria-label="Next page">
            <span class="material-icons-outlined text-lg">chevron_right</span>
        </a>
    <?php else : ?>
        <span class="w-10 h-10 flex items-center justify-center rounded-full border border-pink-100/50 dark:border-slate-800 text-slate-300 dark:text-slate-600 cursor-not-allowed"
              aria-label="Next page (disabled)" aria-disabled="true">
            <span class="material-icons-outlined text-lg">chevron_right</span>
        </span>
    <?php endif; ?>
</nav>
