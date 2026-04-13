<?php
/**
 * WooCommerce Single Product Page
 *
 * Renders the full product detail page with gallery, info, ACF fields, and add-to-cart.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="pt-24 pb-16 bg-background-light dark:bg-background-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        <?php while (have_posts()) : the_post(); ?>
            <?php global $product; ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left: Product Gallery -->
                <div>
                    <?php woocommerce_show_product_images(); ?>
                </div>

                <!-- Right: Product Info -->
                <div class="space-y-6">
                    <!-- Badge (if applicable) -->
                    <?php get_template_part('template-parts/shop/product-badge'); ?>

                    <!-- Title -->
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100">
                        <?php the_title(); ?>
                    </h1>

                    <!-- Price -->
                    <div class="font-sans text-2xl font-bold text-slate-800 dark:text-slate-100">
                        <?php echo $product->get_price_html(); ?>
                    </div>

                    <!-- Description -->
                    <div class="font-sans text-slate-600 dark:text-slate-400 leading-relaxed prose dark:prose-invert">
                        <?php the_content(); ?>
                    </div>

                    <!-- Made to Order Notice -->
                    <?php if (function_exists('get_field')) :
                        $made_to_order = get_field('made_to_order');
                        $turnaround = get_field('turnaround_time');
                        if ($made_to_order) : ?>
                            <div class="flex items-start gap-3 bg-secondary/20 dark:bg-slate-800 border border-secondary/40 dark:border-slate-700 rounded-lg p-4">
                                <span class="material-icons-outlined text-primary mt-0.5">schedule</span>
                                <div>
                                    <p class="font-sans font-semibold text-slate-800 dark:text-slate-100 text-sm">Made to Order</p>
                                    <?php if ($turnaround) : ?>
                                        <p class="font-sans text-sm text-slate-600 dark:text-slate-400">
                                            Estimated turnaround: <?php echo esc_html($turnaround); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif;
                    endif; ?>

                    <!-- Add to Cart -->
                    <?php woocommerce_template_single_add_to_cart(); ?>

                    <!-- Product Meta (Category + Fiber Type) -->
                    <div class="border-t border-pink-100 dark:border-slate-700 pt-4 space-y-2 text-sm font-sans text-slate-500 dark:text-slate-400">
                        <?php
                        $cats = get_the_terms($product->get_id(), 'product_cat');
                        if ($cats && !is_wp_error($cats)) : ?>
                            <p>Category: <span class="text-slate-700 dark:text-slate-300"><?php echo esc_html(implode(', ', wp_list_pluck($cats, 'name'))); ?></span></p>
                        <?php endif; ?>

                        <?php $fiber = hooan_get_product_fiber_type($product->get_id());
                        if ($fiber) : ?>
                            <p>Fiber Type: <span class="text-slate-700 dark:text-slate-300"><?php echo esc_html($fiber); ?></span></p>
                        <?php endif; ?>
                    </div>

                    <!-- ACF Product Details -->
                    <?php get_template_part('template-parts/shop/product-details-section'); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
