<?php
/**
 * Hooked On A Needle Theme Functions
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define theme constants
define('HOOAN_VERSION', '1.0.0');
define('HOOAN_THEME_DIR', get_template_directory());
define('HOOAN_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 */
function hooan_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Add custom image sizes
    add_image_size('hero-large', 1200, 1600, true);
    add_image_size('featured-creation', 800, 1000, true);
    add_image_size('featured-creation-thumb', 400, 500, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'hookedonaneedle'),
        'footer-explore' => __('Footer Explore Menu', 'hookedonaneedle'),
        'footer-support' => __('Footer Support Menu', 'hookedonaneedle'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for Block Styles
    add_theme_support('wp-block-styles');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Product card image size (4:5 ratio)
    add_image_size('product-card', 600, 750, true);

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'hooan_theme_setup');

/**
 * Enqueue scripts and styles
 */
function hooan_enqueue_assets() {
    // Enqueue Google Fonts
    wp_enqueue_style(
        'hooan-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Quicksand:wght@300..700&display=swap',
        array(),
        null
    );

    // Enqueue Material Icons
    wp_enqueue_style(
        'hooan-material-icons',
        'https://fonts.googleapis.com/icon?family=Material+Icons+Outlined',
        array(),
        null
    );

    // Enqueue Tailwind CSS via CDN
    wp_enqueue_script(
        'hooan-tailwind',
        'https://cdn.tailwindcss.com?plugins=forms,typography',
        array(),
        null,
        false
    );

    // Add Tailwind config inline
    wp_add_inline_script('hooan-tailwind', hooan_get_tailwind_config());

    // Enqueue theme stylesheet
    wp_enqueue_style(
        'hooan-style',
        get_stylesheet_uri(),
        array('hooan-google-fonts', 'hooan-material-icons'),
        HOOAN_VERSION
    );

    // Enqueue theme switcher script
    wp_enqueue_script(
        'hooan-theme-switcher',
        HOOAN_THEME_URI . '/assets/js/theme-switcher.js',
        array(),
        HOOAN_VERSION,
        true
    );

    // Enqueue waitlist form script
    wp_enqueue_script(
        'hooan-waitlist-form',
        HOOAN_THEME_URI . '/assets/js/waitlist-form.js',
        array(),
        HOOAN_VERSION,
        true
    );

    // Localize script with AJAX URL and nonce
    wp_localize_script('hooan-waitlist-form', 'hookedOnANeedle', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('hooan_waitlist_nonce'),
    ));

    // Enqueue animations script
    wp_enqueue_script(
        'hooan-animations',
        HOOAN_THEME_URI . '/assets/js/animations.js',
        array(),
        HOOAN_VERSION,
        true
    );

    // Enqueue shop script on WooCommerce pages
    if (function_exists('is_shop') && (is_shop() || is_product_taxonomy())) {
        wp_enqueue_script(
            'hooan-shop',
            HOOAN_THEME_URI . '/assets/js/shop.js',
            array(),
            HOOAN_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'hooan_enqueue_assets');

/**
 * Get Tailwind CSS configuration
 *
 * @return string JavaScript configuration for Tailwind
 */
function hooan_get_tailwind_config() {
    return "
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8B4A4E',
                        secondary: '#EACAC6',
                        'background-light': '#FDF6F5',
                        'background-dark': '#1A1616',
                        'accent-dark': '#1A2332',
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        sans: ['Quicksand', 'sans-serif'],
                    },
                    borderRadius: {
                        DEFAULT: '1rem',
                        'xl': '2rem',
                    },
                },
            },
        };
    ";
}

/**
 * Check if ACF Pro is active
 *
 * @return bool True if ACF Pro is active
 */
function hooan_is_acf_active() {
    return class_exists('ACF');
}

/**
 * Check if waitlist database table exists
 *
 * @return bool True if table exists
 */
function hooan_waitlist_table_exists() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'waitlist_emails';
    return $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) === $table_name;
}

/**
 * Ensure the waitlist table has the `name` column (added in 1.1).
 */
function hooan_maybe_add_waitlist_name_column() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'waitlist_emails';

    if (get_option('hooan_waitlist_schema_version', '1.0') === '1.1') {
        return;
    }

    // Check if column already exists
    $columns = $wpdb->get_col("DESCRIBE {$table_name}", 0);
    if (!in_array('name', $columns, true)) {
        $wpdb->query("ALTER TABLE {$table_name} ADD COLUMN name VARCHAR(255) NOT NULL DEFAULT '' AFTER id");
    }

    update_option('hooan_waitlist_schema_version', '1.1');
}
add_action('admin_init', 'hooan_maybe_add_waitlist_name_column');

/**
 * Display admin notice if ACF is not active
 */
function hooan_acf_admin_notice() {
    if (!hooan_is_acf_active()) {
        $screen = get_current_screen();
        // Only show on relevant screens
        if ($screen && in_array($screen->base, array('dashboard', 'themes', 'plugins', 'page', 'post'))) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p>
                    <strong><?php _e('Hooked On A Needle Theme:', 'hookedonaneedle'); ?></strong>
                    <?php _e('This theme works best with Advanced Custom Fields Pro plugin. Install and activate ACF Pro to unlock full content editing capabilities. The theme will still function with default content.', 'hookedonaneedle'); ?>
                </p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'hooan_acf_admin_notice');

/**
 * Display admin notice if waitlist table is missing
 */
function hooan_waitlist_table_notice() {
    if (!hooan_waitlist_table_exists()) {
        $screen = get_current_screen();
        if ($screen && $screen->base === 'settings_page_waitlist') {
            ?>
            <div class="notice notice-error">
                <p>
                    <strong><?php _e('Database Error:', 'hookedonaneedle'); ?></strong>
                    <?php _e('The waitlist database table is missing. Please deactivate and reactivate the theme to create it.', 'hookedonaneedle'); ?>
                </p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'hooan_waitlist_table_notice');

/**
 * Include required files
 */
// Include ACF field definitions
if (file_exists(HOOAN_THEME_DIR . '/inc/acf-fields.php')) {
    require_once HOOAN_THEME_DIR . '/inc/acf-fields.php';
}

// Include waitlist handler
if (file_exists(HOOAN_THEME_DIR . '/inc/waitlist-handler.php')) {
    require_once HOOAN_THEME_DIR . '/inc/waitlist-handler.php';
}

// Include custom orders handler
if (file_exists(HOOAN_THEME_DIR . '/inc/custom-orders.php')) {
    require_once HOOAN_THEME_DIR . '/inc/custom-orders.php';
}

/**
 * Enqueue TikTok Embed SDK on Social page
 *
 * Conditionally loads the TikTok embed script only on the Social page template.
 */
function hooan_enqueue_tiktok_embed() {
    if (is_page_template('page-social.php')) {
        wp_enqueue_script(
            'tiktok-embed',
            'https://www.tiktok.com/embed.js',
            array(),
            null,
            true
        );
        // Add async attribute
        add_filter('script_loader_tag', 'hooan_add_async_tiktok_script', 10, 2);
    }
}
add_action('wp_enqueue_scripts', 'hooan_enqueue_tiktok_embed');

/**
 * Add async attribute to TikTok embed script
 *
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @return string Modified script tag.
 */
function hooan_add_async_tiktok_script($tag, $handle) {
    if ('tiktok-embed' === $handle) {
        return str_replace(' src', ' async src', $tag);
    }
    return $tag;
}

/**
 * Enqueue Custom Orders page stylesheet
 *
 * Conditionally loads the custom-orders CSS only on the Custom Orders page template.
 */
function hooan_enqueue_custom_orders_assets() {
    if (is_page_template('page-custom-orders.php')) {
        wp_enqueue_style(
            'hooan-custom-orders',
            HOOAN_THEME_URI . '/assets/css/custom-orders.css',
            array('hooan-style'),
            HOOAN_VERSION
        );

        wp_enqueue_script(
            'hooan-custom-orders-js',
            HOOAN_THEME_URI . '/assets/js/custom-orders.js',
            array(),
            HOOAN_VERSION,
            true
        );

        wp_localize_script('hooan-custom-orders-js', 'hookedOnANeedleCommission', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('hooan_commission_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'hooan_enqueue_custom_orders_assets');

/**
 * Enqueue About page stylesheet
 *
 * Conditionally loads the about CSS only on the About page template.
 */
function hooan_enqueue_about_assets() {
    if (is_page_template('page-about.php')) {
        wp_enqueue_style(
            'hooan-about',
            HOOAN_THEME_URI . '/assets/css/about.css',
            array('hooan-style'),
            HOOAN_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'hooan_enqueue_about_assets');

/**
 * Enqueue Learn page stylesheet and script
 *
 * Conditionally loads the learn CSS and JS only on the Learn page template.
 */
function hooan_enqueue_learn_assets() {
    if (is_page_template('page-learn.php')) {
        wp_enqueue_style(
            'hooan-learn',
            HOOAN_THEME_URI . '/assets/css/learn.css',
            array('hooan-style'),
            HOOAN_VERSION
        );

        wp_enqueue_script(
            'hooan-learn',
            HOOAN_THEME_URI . '/assets/js/learn.js',
            array(),
            HOOAN_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'hooan_enqueue_learn_assets');

// Include waitlist admin
if (file_exists(HOOAN_THEME_DIR . '/inc/waitlist-admin.php')) {
    require_once HOOAN_THEME_DIR . '/inc/waitlist-admin.php';
}

// Include WooCommerce setup
if (file_exists(HOOAN_THEME_DIR . '/inc/woocommerce-setup.php')) {
    require_once HOOAN_THEME_DIR . '/inc/woocommerce-setup.php';
}

/**
 * Theme activation hook
 */
function hooan_theme_activation() {
    // Create waitlist database table
    if (class_exists('HOOAN_Waitlist_Handler')) {
        $handler = new HOOAN_Waitlist_Handler();
        $handler->create_table();
    }

    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'hooan_theme_activation');

/**
 * Get hero image URL with fallback
 *
 * @param array|false $image ACF image array or false
 * @param string $size Image size
 * @return string Image URL
 */
function hooan_get_hero_image_url($image, $size = 'hero-large') {
    if ($image && isset($image['sizes'][$size])) {
        return $image['sizes'][$size];
    } elseif ($image && isset($image['url'])) {
        return $image['url'];
    }
    return HOOAN_THEME_URI . '/assets/images/hero-default.jpg';
}

/**
 * Get featured creation image URL with fallback
 *
 * @param array|false $image ACF image array or false
 * @param string $size Image size
 * @return string Image URL
 */
function hooan_get_featured_image_url($image, $size = 'featured-creation') {
    if ($image && isset($image['sizes'][$size])) {
        return $image['sizes'][$size];
    } elseif ($image && isset($image['url'])) {
        return $image['url'];
    }
    return HOOAN_THEME_URI . '/assets/images/placeholder.jpg';
}

/**
 * Get icon class from icon name
 *
 * @param string $icon Icon name (instagram, email, pinterest)
 * @return string Material icon class name
 */
function hooan_get_social_icon($icon) {
    $icons = array(
        'instagram' => 'camera_alt',
        'email'     => 'mail',
        'pinterest' => 'share',
        'facebook'  => 'facebook',
        'twitter'   => 'alternate_email',
    );
    return isset($icons[$icon]) ? $icons[$icon] : 'link';
}

/**
 * Get responsive image attributes for lazy loading
 *
 * @param bool $is_above_fold Whether image is above the fold
 * @return array Image attributes
 */
function hooan_get_image_attrs($is_above_fold = false) {
    if ($is_above_fold) {
        return array(
            'fetchpriority' => 'high',
            'decoding'      => 'async',
        );
    }
    return array(
        'loading'  => 'lazy',
        'decoding' => 'async',
    );
}

/**
 * Output image attributes as HTML string
 *
 * @param bool $is_above_fold Whether image is above the fold
 * @return void
 */
function hooan_image_attrs($is_above_fold = false) {
    $attrs = hooan_get_image_attrs($is_above_fold);
    foreach ($attrs as $key => $value) {
        echo esc_attr($key) . '="' . esc_attr($value) . '" ';
    }
}

/**
 * AJAX Handler for Waitlist Form Submission
 *
 * Handles both logged-in and non-logged-in users.
 */
function hooan_ajax_submit_waitlist() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'hooan_waitlist_nonce')) {
        wp_send_json_error(array(
            'message' => __('Security check failed. Please refresh the page and try again.', 'hookedonaneedle')
        ));
    }

    // Check if email is provided
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        wp_send_json_error(array(
            'message' => __('Please enter your email address.', 'hookedonaneedle')
        ));
    }

    // Check if waitlist handler class exists
    if (!class_exists('HOOAN_Waitlist_Handler')) {
        wp_send_json_error(array(
            'message' => __('Waitlist service is temporarily unavailable. Please try again later.', 'hookedonaneedle')
        ));
    }

    // Check if database table exists
    if (!hooan_waitlist_table_exists()) {
        wp_send_json_error(array(
            'message' => __('Waitlist service is not configured. Please contact the site administrator.', 'hookedonaneedle')
        ));
    }

    // Process the email
    $handler = new HOOAN_Waitlist_Handler();
    $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $result  = $handler->add_email($_POST['email'], $name);

    if ($result['success']) {
        wp_send_json_success(array(
            'message' => $result['message']
        ));
    } else {
        wp_send_json_error(array(
            'message' => $result['message']
        ));
    }
}
add_action('wp_ajax_submit_waitlist', 'hooan_ajax_submit_waitlist');
add_action('wp_ajax_nopriv_submit_waitlist', 'hooan_ajax_submit_waitlist');

/**
 * Send email notification to admin when someone joins the waitlist.
 *
 * @param string $email Subscriber email.
 * @param int    $id    Database row ID.
 * @param string $name  Subscriber name.
 */
function hooan_waitlist_notify_admin($email, $id, $name = '') {
    $admin_email = get_option('admin_email');
    $site_name   = get_bloginfo('name');

    $subject = sprintf(__('[%s] New Waitlist Signup', 'hookedonaneedle'), $site_name);

    $message  = sprintf(__("New waitlist signup on %s:\n\n", 'hookedonaneedle'), $site_name);
    if ($name) {
        $message .= sprintf(__("Name: %s\n", 'hookedonaneedle'), $name);
    }
    $message .= sprintf(__("Email: %s\n", 'hookedonaneedle'), $email);
    $message .= sprintf(__("Date: %s\n", 'hookedonaneedle'), current_time('mysql'));
    $message .= sprintf(__("\nManage waitlist: %s\n", 'hookedonaneedle'), admin_url('options-general.php?page=hooan-waitlist'));

    wp_mail($admin_email, $subject, $message);
}
add_action('hooan_waitlist_submitted', 'hooan_waitlist_notify_admin', 10, 3);
/**
 * Custom Nav Walker for Desktop Navigation
 *
 * Outputs menu items with Tailwind classes.
 */
class HOOAN_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $is_current = in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes);

        if ($is_current) {
            $classes = 'text-primary font-semibold transition-colors';
        } else {
            $classes = 'text-slate-600 dark:text-slate-300 hover:text-primary transition-colors';
        }

        $output .= sprintf(
            '<a href="%s" class="%s"%s>%s</a>',
            esc_url($item->url),
            esc_attr($classes),
            $is_current ? ' aria-current="page"' : '',
            esc_html($item->title)
        );
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        // No closing tag needed for inline links
    }
}

/**
 * Custom Nav Walker for Mobile Navigation
 *
 * Outputs menu items with Tailwind classes for mobile.
 */
class HOOAN_Nav_Walker_Mobile extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $is_current = in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes);

        if ($is_current) {
            $classes = 'text-primary font-semibold transition-colors py-2';
        } else {
            $classes = 'hover:text-primary transition-colors py-2';
        }

        $output .= sprintf(
            '<a href="%s" class="%s"%s>%s</a>',
            esc_url($item->url),
            esc_attr($classes),
            $is_current ? ' aria-current="page"' : '',
            esc_html($item->title)
        );
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        // No closing tag needed for inline links
    }
}

/**
 * Fallback menu for desktop navigation
 *
 * Displays default links when no menu is assigned.
 */
function hooan_fallback_menu() {
    ?>
    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Shop</a>
    <a href="<?php echo esc_url(home_url('/custom-orders')); ?>" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Custom Orders</a>
    <a href="<?php echo esc_url(home_url('/learn')); ?>" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">Learn</a>
    <a href="<?php echo esc_url(home_url('/about')); ?>" class="text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">About</a>
    <?php
}

/**
 * Fallback menu for mobile navigation
 *
 * Displays default links when no menu is assigned.
 */
function hooan_fallback_menu_mobile() {
    ?>
    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="hover:text-primary transition-colors py-2">Shop</a>
    <a href="<?php echo esc_url(home_url('/custom-orders')); ?>" class="hover:text-primary transition-colors py-2">Custom Orders</a>
    <a href="<?php echo esc_url(home_url('/learn')); ?>" class="hover:text-primary transition-colors py-2">Learn</a>
    <a href="<?php echo esc_url(home_url('/about')); ?>" class="hover:text-primary transition-colors py-2">About</a>
    <?php
}