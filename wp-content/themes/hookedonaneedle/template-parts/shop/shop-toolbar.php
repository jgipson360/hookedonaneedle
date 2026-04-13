<?php
/**
 * Shop Toolbar
 *
 * Renders view toggle, per-page selector, sort dropdown, and product count.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wp_query;
$total = $wp_query->found_posts;
$view = isset($_GET['view']) && $_GET['view'] === 'list' ? 'list' : 'grid';
$current_per_page = isset($_GET['per_page']) ? sanitize_text_field($_GET['per_page']) : '12';
$current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';
?>

<div class="flex flex-wrap items-center justify-between mb-10 pb-5 border-b border-pink-100 dark:border-slate-700 gap-6">
    <!-- Left: Product Count + View Toggle -->
    <div class="flex items-center space-x-6 text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest font-sans">
        <span><?php echo esc_html($total); ?> unique pieces</span>
        <div class="hidden md:flex items-center space-x-3">
            <button data-view="grid" aria-label="Grid view"
                    class="transition-colors <?php echo $view === 'grid' ? 'text-primary' : 'text-slate-400 hover:text-primary'; ?>">
                <span class="material-icons-outlined text-lg">grid_view</span>
            </button>
            <button data-view="list" aria-label="List view"
                    class="transition-colors <?php echo $view === 'list' ? 'text-primary' : 'text-slate-400 hover:text-primary'; ?>">
                <span class="material-icons-outlined text-lg">view_list</span>
            </button>
        </div>
    </div>

    <!-- Right: Per-Page + Sort -->
    <div class="flex items-center space-x-10 text-[11px] font-bold uppercase tracking-widest font-sans">
        <!-- Per-Page Selector (hidden on mobile) -->
        <div class="hidden md:flex items-center space-x-3">
            <span class="text-slate-400">Show:</span>
            <div class="space-x-3">
                <?php foreach (array('12', '24', '48', 'all') as $option) :
                    $is_active = ($current_per_page == $option) || ($option === '12' && !isset($_GET['per_page']));
                    $label = $option === 'all' ? 'All' : $option;
                    $url = add_query_arg('per_page', $option);
                ?>
                    <a href="<?php echo esc_url($url); ?>"
                       class="<?php echo $is_active ? 'text-primary' : 'text-slate-500 hover:text-primary'; ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sort Dropdown -->
        <div class="flex items-center space-x-3 md:border-l md:border-pink-100 md:dark:border-slate-700 md:pl-10 h-4">
            <span class="text-slate-400">Sort:</span>
            <select name="orderby"
                    class="bg-transparent border-none focus:ring-0 cursor-pointer font-bold p-0 text-[11px] uppercase tracking-widest outline-none dark:text-slate-300"
                    onchange="var url=new URL(window.location);url.searchParams.set('orderby',this.value);window.location.href=url.toString();">
                <option value="date" <?php selected($current_orderby, 'date'); ?>>Latest Drops</option>
                <option value="price" <?php selected($current_orderby, 'price'); ?>>Price: Low to High</option>
                <option value="price-desc" <?php selected($current_orderby, 'price-desc'); ?>>Price: High to Low</option>
            </select>
        </div>
    </div>
</div>
