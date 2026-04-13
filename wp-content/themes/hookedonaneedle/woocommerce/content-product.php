<?php
/**
 * WooCommerce Content Product
 *
 * Delegates to the theme's product-card template part.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

defined('ABSPATH') || exit;

global $product;
get_template_part('template-parts/shop/product-card');
