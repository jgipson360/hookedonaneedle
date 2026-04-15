<?php
/**
 * Product Card Component
 *
 * Renders a single product card in the shop grid.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
if (!$product) {
    return;
}

$product_id = $product->get_id();
$thumbnail_url = get_the_post_thumbnail_url($product_id, 'product-card');
if (!$thumbnail_url) {
    $thumbnail_url = wc_placeholder_img_src('product-card');
}

// Get category name
$categories = get_the_terms($product_id, 'product_cat');
$category_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : '';

// Get fiber type
$fiber_type = hooan_get_product_fiber_type($product_id);
?>

<a href="<?php the_permalink(); ?>" class="product-card group block cursor-pointer">
    <!-- Image Container: 4:5 aspect ratio -->
    <div class="relative aspect-[4/5] overflow-hidden rounded-lg bg-secondary/30 dark:bg-slate-800 mb-5">
        <?php get_template_part('template-parts/shop/product-badge'); ?>

        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>"
            class="product-image w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-[1.02]"
            <?php hooan_image_attrs(false); ?> />
    </div>

    <!-- Product Info -->
    <h3
        class="font-display text-xl mb-1.5 group-hover:text-primary transition-colors text-slate-800 dark:text-slate-100">
        <?php the_title(); ?>
    </h3>

    <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] mb-2 font-medium font-sans">
        <?php if ($category_name) : ?>
        <span><?php echo esc_html($category_name); ?></span>
        <?php endif; ?>
        <?php if ($category_name && $fiber_type) : ?>
        <span class="mx-1">&bull;</span>
        <?php endif; ?>
        <?php if ($fiber_type) : ?>
        <span><?php echo esc_html($fiber_type); ?></span>
        <?php endif; ?>
    </p>

    <p class="font-bold text-lg tracking-tight text-slate-800 dark:text-slate-100 font-sans">
        <?php echo $product->get_price_html(); ?>
    </p>
</a>