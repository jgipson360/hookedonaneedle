<?php
/**
 * Product Badge Overlay
 *
 * Renders a "Limited Drop" or "One of One" badge on the product image.
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

$badge = hooan_get_product_badge($product->get_id());
if (!$badge) {
    return;
}
?>

<?php if ($badge['type'] === 'limited_drop') : ?>
    <span class="absolute top-3 left-3 z-10 bg-primary text-white text-[9px] uppercase tracking-[0.2em] font-sans font-bold px-2.5 py-1.5">
        <?php echo esc_html($badge['label']); ?>
    </span>
<?php elseif ($badge['type'] === 'one_of_one') : ?>
    <span class="absolute top-3 left-3 z-10 bg-white/90 dark:bg-slate-900/80 text-primary border border-primary/20 text-[9px] uppercase tracking-[0.2em] font-sans font-bold px-2.5 py-1.5 backdrop-blur-sm">
        <?php echo esc_html($badge['label']); ?>
    </span>
<?php endif; ?>
