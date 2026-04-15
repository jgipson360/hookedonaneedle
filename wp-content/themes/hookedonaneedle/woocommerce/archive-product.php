<?php
/**
 * WooCommerce Archive Product (Shop Page)
 *
 * Renders the shop page with hero, toolbar, sidebar, product grid, and pagination.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="pt-24 pb-16 bg-background-light dark:bg-background-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <?php get_template_part('template-parts/shop/shop-hero'); ?>

        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 lg:flex-shrink-0">
                <?php get_template_part('template-parts/shop/shop-sidebar'); ?>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <?php get_template_part('template-parts/shop/shop-toolbar'); ?>

                <?php if (woocommerce_product_loop()) : ?>
                    <?php woocommerce_product_loop_start(); ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>
                    <?php woocommerce_product_loop_end(); ?>
                <?php else : ?>
                    <div class="text-center py-16">
                        <span class="material-icons-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4 block">inventory_2</span>
                        <p class="text-slate-500 dark:text-slate-400 font-sans text-lg">No products found.</p>
                    </div>
                <?php endif; ?>

                <?php get_template_part('template-parts/shop/pagination'); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
