<?php
/**
 * Shop Sidebar
 *
 * Renders category filter list and Custom Order CTA.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$categories = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
));
$active_cat = hooan_get_active_product_cat();
?>

<div class="space-y-12">
    <!-- Categories Section -->
    <div>
        <h3 class="font-display text-xs uppercase tracking-[0.2em] mb-8 border-b border-pink-100 dark:border-slate-700 pb-3 font-bold text-slate-800 dark:text-slate-200">
            Categories
        </h3>
        <?php if ($categories && !is_wp_error($categories)) : ?>
            <ul class="space-y-5 text-sm font-sans">
                <?php foreach ($categories as $cat) :
                    $is_active = ($active_cat === $cat->slug);
                    $link = get_term_link($cat);
                    if (is_wp_error($link)) {
                        continue;
                    }
                ?>
                    <li>
                        <a href="<?php echo esc_url($link); ?>"
                           class="flex justify-between items-center transition-colors
                                  <?php echo $is_active
                                      ? 'font-bold text-primary'
                                      : 'text-slate-600 dark:text-slate-400 hover:text-primary'; ?>">
                            <span><?php echo esc_html($cat->name); ?></span>
                            <?php if ($is_active) : ?>
                                <span class="bg-primary text-white text-[9px] px-2 py-0.5 rounded-full font-bold">
                                    <?php echo esc_html($cat->count); ?>
                                </span>
                            <?php else : ?>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                                    <?php echo esc_html($cat->count); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Custom Order CTA -->
    <div class="bg-secondary/20 dark:bg-slate-800/50 p-8 rounded-lg border border-secondary/40 dark:border-slate-700">
        <h4 class="font-display text-lg mb-3 text-slate-800 dark:text-slate-100">
            Custom Request?
        </h4>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed font-sans">
            Looking for a specific color or size? We take commissions for unique handmade pieces.
        </p>
        <a href="<?php echo esc_url(home_url('/custom-orders')); ?>"
           class="inline-flex items-center text-primary font-bold text-xs uppercase tracking-widest hover:underline font-sans">
            Contact us
            <span class="material-icons-outlined text-sm ml-2">arrow_forward</span>
        </a>
    </div>
</div>
