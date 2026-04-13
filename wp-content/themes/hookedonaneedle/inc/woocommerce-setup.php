<?php
/**
 * WooCommerce Setup and Configuration
 *
 * Handles: product categories, fiber type attribute, cart fragments,
 * query modifications, loop overrides, and template helpers.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register default product categories on theme activation
 */
function hooan_register_default_product_categories() {
    $categories = array(
        'Fashion',
        'Baby & Nursery',
        'Home Decor',
        'Novelty & Plushies',
    );

    foreach ($categories as $name) {
        if (!term_exists($name, 'product_cat')) {
            wp_insert_term($name, 'product_cat');
        }
    }
}
add_action('after_switch_theme', 'hooan_register_default_product_categories');

/**
 * Register Fiber Type product attribute on init
 */
function hooan_register_fiber_type_attribute() {
    if (!function_exists('wc_create_attribute')) {
        return;
    }

    $existing = wc_get_attribute_taxonomies();
    foreach ($existing as $attr) {
        if ($attr->attribute_name === 'fiber_type') {
            return;
        }
    }

    wc_create_attribute(array(
        'name'         => 'Fiber Type',
        'slug'         => 'fiber_type',
        'type'         => 'select',
        'order_by'     => 'menu_order',
        'has_archives' => false,
    ));

    register_taxonomy('pa_fiber_type', 'product', array(
        'label'        => 'Fiber Type',
        'public'       => true,
        'hierarchical' => false,
        'show_ui'      => true,
    ));
}
add_action('init', 'hooan_register_fiber_type_attribute');

/**
 * Seed default fiber type terms on theme activation
 */
function hooan_seed_fiber_type_terms() {
    $terms = array('Cotton', 'Wool Blend', 'Alpaca Fiber', 'Acrylic', 'Organic Wool', 'Jute & Cotton');
    foreach ($terms as $term) {
        if (!term_exists($term, 'pa_fiber_type')) {
            wp_insert_term($term, 'pa_fiber_type');
        }
    }
}
add_action('after_switch_theme', 'hooan_seed_fiber_type_terms');

/**
 * Cart badge AJAX fragment for live updates
 */
function hooan_cart_badge_fragment($fragments) {
    ob_start();
    get_template_part('template-parts/shop/cart-badge');
    $fragments['.hooan-cart-badge'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'hooan_cart_badge_fragment');

/**
 * Render cart badge in header via action hook
 */
function hooan_render_header_cart() {
    if (!function_exists('WC')) {
        return;
    }
    get_template_part('template-parts/shop/cart-badge');
}
add_action('hooan_header_cart', 'hooan_render_header_cart');

/**
 * Modify products per page based on URL parameter
 */
function hooan_shop_products_per_page($cols) {
    if (isset($_GET['per_page'])) {
        $per_page = sanitize_text_field($_GET['per_page']);
        if ($per_page === 'all') {
            return -1;
        }
        $per_page = intval($per_page);
        if (in_array($per_page, array(12, 24, 48), true)) {
            return $per_page;
        }
    }
    return 12;
}
add_filter('loop_shop_per_page', 'hooan_shop_products_per_page');

/**
 * Override product loop start with custom grid/list container
 */
function hooan_product_loop_start() {
    $view = isset($_GET['view']) && $_GET['view'] === 'list' ? 'list' : 'grid';
    $grid_classes = $view === 'list'
        ? 'flex flex-col gap-6'
        : 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-8 gap-y-12';
    return '<div id="product-grid" class="' . esc_attr($grid_classes) . '" data-view="' . esc_attr($view) . '">';
}
add_filter('woocommerce_product_loop_start', 'hooan_product_loop_start');

/**
 * Override product loop end
 */
function hooan_product_loop_end() {
    return '</div>';
}
add_filter('woocommerce_product_loop_end', 'hooan_product_loop_end');

/**
 * Get product fiber type display string
 *
 * @param int $product_id
 * @return string Comma-separated fiber types or empty string
 */
function hooan_get_product_fiber_type($product_id) {
    $terms = get_the_terms($product_id, 'pa_fiber_type');
    if ($terms && !is_wp_error($terms)) {
        return implode(', ', wp_list_pluck($terms, 'name'));
    }
    return '';
}

/**
 * Get product badge data from ACF
 *
 * @param int $product_id
 * @return array|null Badge data with 'type' and 'label' keys, or null
 */
function hooan_get_product_badge($product_id) {
    if (!function_exists('get_field')) {
        return null;
    }
    $badge = get_field('product_badge', $product_id);
    if (!$badge || $badge === 'none') {
        return null;
    }
    $badges = array(
        'limited_drop' => array('type' => 'limited_drop', 'label' => 'Limited Drop'),
        'one_of_one'   => array('type' => 'one_of_one', 'label' => 'One of One'),
    );
    return isset($badges[$badge]) ? $badges[$badge] : null;
}

/**
 * Get the current active product category slug from the query
 *
 * @return string|null Category slug or null
 */
function hooan_get_active_product_cat() {
    if (is_product_category()) {
        $term = get_queried_object();
        return $term ? $term->slug : null;
    }
    return null;
}
