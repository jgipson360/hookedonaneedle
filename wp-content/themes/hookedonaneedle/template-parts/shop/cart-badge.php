<?php
/**
 * Cart Badge Component
 *
 * Renders shopping bag icon with cart item count in the header.
 * Wrapped in .hooan-cart-badge for WooCommerce AJAX cart fragment updates.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
?>

<a href="<?php echo esc_url($cart_url); ?>"
   class="hooan-cart-badge relative p-2 rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 transition-colors"
   aria-label="<?php printf(esc_attr__('Shopping bag, %d items', 'hookedonaneedle'), $cart_count); ?>">
    <span class="material-icons-outlined">shopping_bag</span>
    <?php if ($cart_count > 0) : ?>
        <span class="absolute -top-1 -right-1 bg-primary text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full font-sans">
            <?php echo esc_html($cart_count); ?>
        </span>
    <?php endif; ?>
</a>
