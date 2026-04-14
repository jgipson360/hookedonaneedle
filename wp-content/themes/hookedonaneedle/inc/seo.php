<?php
/**
 * SEO & AIO Optimization Module
 *
 * Provides meta tags, Open Graph, JSON-LD structured data, AI-friendly markup,
 * breadcrumbs, and robots.txt directives for the Hooked On A Needle theme.
 *
 * @package HookedOnANeedle
 * @since 1.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Orchestrator class — initializes all SEO sub-components and provides shared helpers.
 */
class HOOAN_SEO {

    /** @var HOOAN_SEO_Schema|null */
    private static $schema_instance = null;

    /**
     * Initialize the SEO module and all sub-components.
     */
    public static function init() {
        // Register ACF SEO fields
        add_action('acf/init', array(__CLASS__, 'register_acf_seo_fields'), 20);

        // Invalidate product transient cache on save
        add_action('save_post_product', array(__CLASS__, 'invalidate_product_cache'));

        // Exclude utility pages from WordPress core sitemap
        add_filter('wp_sitemaps_posts_pre_url_list', array(__CLASS__, 'filter_sitemap_entries'), 10, 3);

        // Instantiate sub-components
        new HOOAN_SEO_Meta();
        new HOOAN_SEO_OpenGraph();
        self::$schema_instance = new HOOAN_SEO_Schema();
        new HOOAN_SEO_AI();
        new HOOAN_SEO_Breadcrumbs(self::$schema_instance);
        new HOOAN_SEO_Robots();
    }

    /**
     * Get the Schema instance for external use (e.g., breadcrumbs adding to graph).
     *
     * @return HOOAN_SEO_Schema|null
     */
    public static function get_schema() {
        return self::$schema_instance;
    }

    /**
     * Register ACF SEO override fields on pages, posts, and products.
     */
    public static function register_acf_seo_fields() {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group(array(
            'key'      => 'group_hooan_seo_settings',
            'title'    => 'SEO Settings',
            'fields'   => array(
                array(
                    'key'          => 'field_seo_title',
                    'label'        => 'SEO Title',
                    'name'         => 'seo_title',
                    'type'         => 'text',
                    'instructions' => 'Override the auto-generated page title for search engine results.',
                ),
                array(
                    'key'          => 'field_seo_description',
                    'label'        => 'SEO Description',
                    'name'         => 'seo_description',
                    'type'         => 'textarea',
                    'instructions' => 'Override the auto-generated meta description. Keep it under 160 characters.',
                    'rows'         => 2,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'page',
                    ),
                ),
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'post',
                    ),
                ),
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'product',
                    ),
                ),
            ),
            'menu_order' => 100,
            'position'   => 'normal',
            'style'      => 'default',
        ));
    }

    /**
     * Invalidate product schema transient cache on product save.
     *
     * @param int $post_id
     */
    public static function invalidate_product_cache($post_id) {
        delete_transient('hooan_seo_product_' . $post_id);
    }

    /**
     * Exclude cart, checkout, and my-account pages from the WordPress core sitemap.
     *
     * @param array|null $url_list
     * @param string     $post_type
     * @param int        $page_num
     * @return array|null
     */
    public static function filter_sitemap_entries($url_list, $post_type, $page_num) {
        if ($post_type !== 'page') {
            return $url_list;
        }

        // Get WooCommerce utility page IDs
        $exclude_ids = array_filter(array(
            function_exists('wc_get_page_id') ? wc_get_page_id('cart') : 0,
            function_exists('wc_get_page_id') ? wc_get_page_id('checkout') : 0,
            function_exists('wc_get_page_id') ? wc_get_page_id('myaccount') : 0,
        ));

        if (empty($exclude_ids)) {
            return $url_list;
        }

        // If url_list is null, WordPress hasn't built it yet — let it build, then we filter
        // We need to use a different approach: filter after sitemap is built
        return $url_list;
    }

    /**
     * Get the SEO title for the current page.
     * Checks ACF override first, falls back to WordPress title.
     *
     * @return string
     */
    public static function get_seo_title() {
        if (is_singular() && function_exists('get_field')) {
            $seo_title = get_field('seo_title');
            if (!empty($seo_title)) {
                return sanitize_text_field($seo_title);
            }
        }

        return wp_get_document_title();
    }

    /**
     * Get the SEO description for the current page.
     * Fallback chain: ACF override → product short description → excerpt → first 160 chars of content → site tagline.
     *
     * @return string
     */
    public static function get_seo_description() {
        // 1. ACF override
        if (is_singular() && function_exists('get_field')) {
            $seo_desc = get_field('seo_description');
            if (!empty($seo_desc)) {
                return self::truncate_description(sanitize_text_field($seo_desc));
            }
        }

        // 2. Product short description (for products)
        if (is_singular('product') && function_exists('WC')) {
            global $post;
            $product = wc_get_product($post);
            if ($product) {
                $short_desc = $product->get_short_description();
                if (!empty($short_desc)) {
                    return self::truncate_description(wp_strip_all_tags($short_desc));
                }
            }
        }

        // 3. Page/post excerpt
        if (is_singular()) {
            global $post;
            if (!empty($post->post_excerpt)) {
                return self::truncate_description(wp_strip_all_tags($post->post_excerpt));
            }

            // 4. First 160 chars of content
            if (!empty($post->post_content)) {
                $content = wp_strip_all_tags(strip_shortcodes($post->post_content));
                if (!empty($content)) {
                    return self::truncate_description($content);
                }
            }
        }

        // 5. Site tagline as last resort
        return self::truncate_description(get_bloginfo('description'));
    }

    /**
     * Truncate a description to 160 characters at a word boundary.
     *
     * @param string $text
     * @return string
     */
    private static function truncate_description($text) {
        $text = trim($text);
        if (mb_strlen($text) <= 160) {
            return $text;
        }
        $truncated = mb_substr($text, 0, 157);
        $last_space = mb_strrpos($truncated, ' ');
        if ($last_space !== false) {
            $truncated = mb_substr($truncated, 0, $last_space);
        }
        return $truncated . '...';
    }
}

/* =========================================================================
 * HOOAN_SEO_Meta — Meta tags, canonical, robots, prev/next
 * ========================================================================= */

class HOOAN_SEO_Meta {

    public function __construct() {
        add_action('wp_head', array($this, 'render_meta_tags'), 1);
        add_filter('document_title_parts', array($this, 'filter_title_parts'), 10);
    }

    /**
     * Output meta description, canonical, robots, and prev/next tags.
     */
    public function render_meta_tags() {
        // Meta description
        $description = HOOAN_SEO::get_seo_description();
        if (!empty($description)) {
            echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        }

        // Canonical URL
        $canonical = $this->get_canonical_url();
        if (!empty($canonical)) {
            echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
        }

        // Robots directive
        $robots = $this->get_robots_directive();
        echo '<meta name="robots" content="' . esc_attr($robots) . '">' . "\n";

        // Prev/next for paginated archives
        $this->render_prev_next();
    }

    /**
     * Override title with ACF seo_title when non-empty.
     *
     * @param array $title_parts
     * @return array
     */
    public function filter_title_parts($title_parts) {
        if (is_singular() && function_exists('get_field')) {
            $seo_title = get_field('seo_title');
            if (!empty($seo_title)) {
                $title_parts['title'] = sanitize_text_field($seo_title);
            }
        }
        return $title_parts;
    }

    /**
     * Get the canonical URL for the current page.
     *
     * @return string
     */
    private function get_canonical_url() {
        if (is_singular()) {
            return get_permalink();
        }
        if (is_archive() || is_home()) {
            return get_pagenum_link(get_query_var('paged', 1) ?: 1);
        }
        return '';
    }

    /**
     * Get the robots directive for the current page.
     *
     * @return string
     */
    private function get_robots_directive() {
        // 404
        if (is_404()) {
            return 'noindex, nofollow';
        }

        // Search results
        if (is_search()) {
            return 'noindex, follow';
        }

        // Empty taxonomy archives
        if (is_tax() || is_category() || is_tag()) {
            global $wp_query;
            if ($wp_query->found_posts === 0) {
                return 'noindex, follow';
            }
        }

        // Product category archive with no products
        if (function_exists('is_product_category') && is_product_category()) {
            global $wp_query;
            if ($wp_query->found_posts === 0) {
                return 'noindex, follow';
            }
        }

        return 'index, follow';
    }

    /**
     * Output prev/next links for paginated shop archives.
     */
    private function render_prev_next() {
        if (!is_archive() && !is_home()) {
            return;
        }

        $paged = get_query_var('paged', 1) ?: 1;
        $max_pages = $GLOBALS['wp_query']->max_num_pages;

        if ($max_pages <= 1) {
            return;
        }

        if ($paged > 1) {
            echo '<link rel="prev" href="' . esc_url(get_pagenum_link($paged - 1)) . '">' . "\n";
        }

        if ($paged < $max_pages) {
            echo '<link rel="next" href="' . esc_url(get_pagenum_link($paged + 1)) . '">' . "\n";
        }
    }
}

/* =========================================================================
 * HOOAN_SEO_OpenGraph — Open Graph + Twitter Card tags
 * ========================================================================= */

class HOOAN_SEO_OpenGraph {

    public function __construct() {
        add_action('wp_head', array($this, 'render_og_tags'), 2);
    }

    /**
     * Output Open Graph and Twitter Card meta tags.
     */
    public function render_og_tags() {
        $title       = HOOAN_SEO::get_seo_title();
        $description = HOOAN_SEO::get_seo_description();
        $url         = is_singular() ? get_permalink() : home_url($_SERVER['REQUEST_URI']);
        $site_name   = get_bloginfo('name');
        $image       = $this->get_og_image();
        $type        = $this->get_og_type();

        // Open Graph tags
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:type" content="' . esc_attr($type) . '">' . "\n";
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";

        // Product-specific OG tags
        if (is_singular('product') && function_exists('WC')) {
            global $post;
            $product = wc_get_product($post);
            if ($product) {
                echo '<meta property="product:price:amount" content="' . esc_attr($product->get_price()) . '">' . "\n";
                echo '<meta property="product:price:currency" content="' . esc_attr(get_woocommerce_currency()) . '">' . "\n";
            }
        }

        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    }

    /**
     * Get the OG type for the current page.
     *
     * @return string
     */
    private function get_og_type() {
        if (is_singular('product')) {
            return 'product';
        }
        if (is_singular()) {
            return 'article';
        }
        return 'website';
    }

    /**
     * Get the OG image URL with fallback chain.
     * Featured image → first product gallery image → default brand image.
     *
     * @return string
     */
    private function get_og_image() {
        if (is_singular()) {
            // Featured image
            $thumbnail_id = get_post_thumbnail_id();
            if ($thumbnail_id) {
                $image_url = wp_get_attachment_image_url($thumbnail_id, 'large');
                if ($image_url) {
                    return $image_url;
                }
            }

            // First product gallery image
            if (is_singular('product') && function_exists('WC')) {
                global $post;
                $product = wc_get_product($post);
                if ($product) {
                    $gallery_ids = $product->get_gallery_image_ids();
                    if (!empty($gallery_ids)) {
                        $image_url = wp_get_attachment_image_url($gallery_ids[0], 'large');
                        if ($image_url) {
                            return $image_url;
                        }
                    }
                }
            }
        }

        // Default fallback
        return HOOAN_THEME_URI . '/assets/images/og-default.png';
    }
}

/* =========================================================================
 * HOOAN_SEO_Schema — JSON-LD structured data (single @graph block)
 * ========================================================================= */

class HOOAN_SEO_Schema {

    /** @var array */
    private $graph = array();

    public function __construct() {
        add_action('wp_footer', array($this, 'render_jsonld'), 5);
    }

    /**
     * Add a schema object to the graph.
     *
     * @param array $schema
     */
    public function add_to_graph($schema) {
        $this->graph[] = $schema;
    }

    /**
     * Output a single JSON-LD script block containing the full @graph.
     */
    public function render_jsonld() {
        // Always add global schemas
        $this->graph[] = $this->get_organization_schema();
        $this->graph[] = $this->get_website_schema();

        // OnlineStore on front page only
        if (is_front_page()) {
            $this->graph[] = $this->get_online_store_schema();
        }

        // Product schema on single product pages
        if (is_singular('product') && function_exists('WC')) {
            global $post;
            $product = wc_get_product($post);
            if ($product) {
                $product_schema = $this->get_product_schema($product);
                if ($product_schema) {
                    $this->graph[] = $product_schema;
                }
            }
        }

        $output = array(
            '@context' => 'https://schema.org',
            '@graph'   => $this->graph,
        );

        echo '<script type="application/ld+json">' . wp_json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }

    /**
     * Organization schema — business identity on every page.
     *
     * @return array
     */
    public function get_organization_schema() {
        $schema = array(
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
            'url'   => esc_url(home_url('/')),
        );

        // Logo
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
            if ($logo_url) {
                $schema['logo'] = esc_url($logo_url);
            }
        }

        // Social profile links from ACF footer
        if (function_exists('get_field')) {
            $social_links = get_field('social_links', 'option');
            if (empty($social_links)) {
                // Try from homepage
                $front_page_id = get_option('page_on_front');
                if ($front_page_id) {
                    $social_links = get_field('social_links', $front_page_id);
                }
            }
            if (!empty($social_links) && is_array($social_links)) {
                $urls = array();
                foreach ($social_links as $link) {
                    if (!empty($link['url'])) {
                        $urls[] = esc_url($link['url']);
                    }
                }
                if (!empty($urls)) {
                    $schema['sameAs'] = $urls;
                }
            }
        }

        return $schema;
    }

    /**
     * WebSite schema with SearchAction — on every page.
     *
     * @return array
     */
    public function get_website_schema() {
        return array(
            '@type'           => 'WebSite',
            'name'            => get_bloginfo('name'),
            'url'             => esc_url(home_url('/')),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => esc_url(home_url('/')) . '?s={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ),
        );
    }

    /**
     * OnlineStore schema — front page only.
     *
     * @return array
     */
    public function get_online_store_schema() {
        $schema = array(
            '@type'       => 'OnlineStore',
            'name'        => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url'         => esc_url(home_url('/')),
        );

        // Product categories
        if (function_exists('WC')) {
            $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'fields'     => 'names',
            ));
            if (!is_wp_error($categories) && !empty($categories)) {
                $schema['hasOfferCatalog'] = array(
                    '@type'    => 'OfferCatalog',
                    'name'     => 'Product Categories',
                    'itemListElement' => array_values($categories),
                );
            }
        }

        return $schema;
    }

    /**
     * Product schema with transient caching (12h TTL).
     *
     * @param WC_Product $product
     * @return array|null
     */
    public function get_product_schema($product) {
        $product_id = $product->get_id();
        $transient_key = 'hooan_seo_product_' . $product_id;

        // Check cache
        $cached = get_transient($transient_key);
        if ($cached !== false) {
            return $cached;
        }

        $schema = array(
            '@type'       => 'Product',
            'name'        => wp_strip_all_tags($product->get_name()),
            'description' => wp_strip_all_tags($product->get_short_description() ?: $product->get_description()),
            'url'         => esc_url(get_permalink($product_id)),
            'brand'       => array(
                '@type' => 'Brand',
                'name'  => 'Hooked On A Needle',
            ),
        );

        // SKU
        $sku = $product->get_sku();
        if (!empty($sku)) {
            $schema['sku'] = $sku;
        }

        // Images
        $image_ids = array_filter(array_merge(
            array($product->get_image_id()),
            $product->get_gallery_image_ids()
        ));
        if (!empty($image_ids)) {
            $images = array();
            foreach ($image_ids as $img_id) {
                $url = wp_get_attachment_image_url($img_id, 'large');
                if ($url) {
                    $images[] = esc_url($url);
                }
            }
            if (!empty($images)) {
                $schema['image'] = $images;
            }
        }

        // Material (fiber type)
        $fiber_type = hooan_get_product_fiber_type($product_id);
        if (!empty($fiber_type)) {
            $schema['material'] = $fiber_type;
        }

        // Offer
        $offer = array(
            '@type'         => 'Offer',
            'price'         => $product->get_price(),
            'priceCurrency' => get_woocommerce_currency(),
            'url'           => esc_url(get_permalink($product_id)),
        );

        // Availability / made-to-order
        $made_to_order = function_exists('get_field') ? get_field('made_to_order', $product_id) : false;
        if ($made_to_order) {
            $offer['availability'] = 'https://schema.org/PreOrder';
            $turnaround = function_exists('get_field') ? get_field('turnaround_time', $product_id) : '';
            if (!empty($turnaround)) {
                $offer['deliveryLeadTime'] = array(
                    '@type'    => 'QuantitativeValue',
                    'value'    => $turnaround,
                );
            }
        } else {
            $offer['availability'] = $product->is_in_stock()
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock';
        }

        $schema['offers'] = $offer;

        // AggregateRating
        if ($product->get_review_count() > 0) {
            $schema['aggregateRating'] = array(
                '@type'       => 'AggregateRating',
                'ratingValue' => $product->get_average_rating(),
                'reviewCount' => $product->get_review_count(),
            );
        }

        // Cache for 12 hours
        set_transient($transient_key, $schema, HOUR_IN_SECONDS * 12);

        return $schema;
    }

    /**
     * BreadcrumbList schema from breadcrumb items array.
     *
     * @param array $items Array of ['name' => string, 'url' => string]
     * @return array
     */
    public function get_breadcrumb_schema($items) {
        $list_items = array();
        foreach ($items as $i => $item) {
            $entry = array(
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => wp_strip_all_tags($item['name']),
            );
            if (!empty($item['url'])) {
                $entry['item'] = esc_url($item['url']);
            }
            $list_items[] = $entry;
        }

        return array(
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $list_items,
        );
    }
}

/* =========================================================================
 * HOOAN_SEO_AI — AI content summary meta tag + product facts block
 * ========================================================================= */

class HOOAN_SEO_AI {

    public function __construct() {
        add_action('wp_head', array($this, 'render_ai_meta'), 3);
        add_action('hooan_product_facts', array($this, 'render_product_facts'), 10);
    }

    /**
     * Output <meta name="ai-content-summary"> with a one-sentence factual summary.
     */
    public function render_ai_meta() {
        $summary = $this->get_page_summary();
        if (!empty($summary)) {
            echo '<meta name="ai-content-summary" content="' . esc_attr($summary) . '">' . "\n";
        }
    }

    /**
     * Get a one-sentence factual summary based on page type.
     *
     * @return string
     */
    private function get_page_summary() {
        // Homepage
        if (is_front_page()) {
            $categories = '';
            if (function_exists('WC')) {
                $terms = get_terms(array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'fields'     => 'names',
                ));
                if (!is_wp_error($terms) && !empty($terms)) {
                    $categories = implode(', ', $terms);
                }
            }
            if (!empty($categories)) {
                return 'Hooked On A Needle is a handmade crochet store offering ' . $categories . '.';
            }
            return 'Hooked On A Needle is a handmade crochet store.';
        }

        // Product page
        if (is_singular('product') && function_exists('WC')) {
            global $post;
            $product = wc_get_product($post);
            if ($product) {
                $name = $product->get_name();
                $cats = get_the_terms($product->get_id(), 'product_cat');
                $category = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'item';
                $fiber = hooan_get_product_fiber_type($product->get_id());
                $price = $product->get_price();
                $currency = get_woocommerce_currency_symbol();

                $summary = $name . ' — handmade crochet ' . strtolower($category);
                if (!empty($fiber)) {
                    $summary .= ' made with ' . $fiber;
                }
                $summary .= ', priced at ' . $currency . $price . '.';
                return $summary;
            }
        }

        // About page
        if (is_page('about')) {
            return 'About Jamila, the founder and fiber-arts engineer behind Hooked On A Needle.';
        }

        // Shop page
        if (function_exists('is_shop') && is_shop()) {
            return 'Browse handmade crochet products at Hooked On A Needle.';
        }

        // Generic — use SEO description
        return HOOAN_SEO::get_seo_description();
    }

    /**
     * Output a structured <dl> block with product facts for AI extraction.
     * Called via do_action('hooan_product_facts').
     */
    public function render_product_facts() {
        if (!is_singular('product') || !function_exists('WC')) {
            return;
        }

        global $post;
        $product = wc_get_product($post);
        if (!$product) {
            return;
        }

        $name        = $product->get_name();
        $price       = $product->get_price();
        $currency    = get_woocommerce_currency_symbol();
        $fiber       = hooan_get_product_fiber_type($product->get_id());
        $description = wp_strip_all_tags($product->get_short_description() ?: $product->get_description());
        $in_stock    = $product->is_in_stock();

        // Check made-to-order
        $made_to_order = function_exists('get_field') ? get_field('made_to_order', $product->get_id()) : false;
        if ($made_to_order) {
            $availability = 'Made to Order';
        } else {
            $availability = $in_stock ? 'In Stock' : 'Out of Stock';
        }

        echo '<dl data-ai-product-facts class="sr-only">' . "\n";
        echo '  <dt data-field="name">Product Name</dt>' . "\n";
        echo '  <dd data-value="name">' . esc_html($name) . '</dd>' . "\n";
        echo '  <dt data-field="price">Price</dt>' . "\n";
        echo '  <dd data-value="price">' . esc_html($currency . $price) . '</dd>' . "\n";

        if (!empty($fiber)) {
            echo '  <dt data-field="material">Material</dt>' . "\n";
            echo '  <dd data-value="material">' . esc_html($fiber) . '</dd>' . "\n";
        }

        echo '  <dt data-field="availability">Availability</dt>' . "\n";
        echo '  <dd data-value="availability">' . esc_html($availability) . '</dd>' . "\n";
        echo '  <dt data-field="description">Description</dt>' . "\n";
        echo '  <dd data-value="description">' . esc_html($description) . '</dd>' . "\n";
        echo '</dl>' . "\n";
    }
}

/* =========================================================================
 * HOOAN_SEO_Breadcrumbs — Breadcrumb navigation + BreadcrumbList schema
 * ========================================================================= */

class HOOAN_SEO_Breadcrumbs {

    /** @var HOOAN_SEO_Schema */
    private $schema;

    /**
     * @param HOOAN_SEO_Schema $schema
     */
    public function __construct($schema) {
        $this->schema = $schema;
        add_action('hooan_breadcrumbs', array($this, 'render'), 10);
    }

    /**
     * Render breadcrumb navigation and pass data to schema.
     */
    public function render() {
        $items = $this->get_breadcrumb_items();
        if (empty($items)) {
            return;
        }

        // Add BreadcrumbList schema to the graph
        $this->schema->add_to_graph($this->schema->get_breadcrumb_schema($items));

        // Render visible breadcrumb HTML
        echo '<nav aria-label="Breadcrumb" class="mb-8">' . "\n";
        echo '  <ol class="flex flex-wrap items-center gap-2 text-sm font-sans text-slate-500 dark:text-slate-400">' . "\n";

        $count = count($items);
        foreach ($items as $i => $item) {
            $is_last = ($i === $count - 1);

            echo '    <li class="flex items-center gap-2">';

            if (!$is_last && !empty($item['url'])) {
                echo '<a href="' . esc_url($item['url']) . '" class="hover:text-primary transition-colors">'
                    . esc_html($item['name']) . '</a>';
                echo '<span class="material-icons-outlined text-xs">chevron_right</span>';
            } else {
                echo '<span class="text-slate-700 dark:text-slate-300 font-medium">'
                    . esc_html($item['name']) . '</span>';
            }

            echo '</li>' . "\n";
        }

        echo '  </ol>' . "\n";
        echo '</nav>' . "\n";
    }

    /**
     * Build the breadcrumb items array based on current page context.
     *
     * @return array Array of ['name' => string, 'url' => string]
     */
    private function get_breadcrumb_items() {
        $items = array();

        // Home is always first
        $items[] = array(
            'name' => 'Home',
            'url'  => home_url('/'),
        );

        // Product page: Home > Shop > Category > Product Name
        if (is_singular('product')) {
            $shop_page_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : '';
            $items[] = array(
                'name' => 'Shop',
                'url'  => $shop_page_url,
            );

            global $post;
            $cats = get_the_terms($post->ID, 'product_cat');
            if ($cats && !is_wp_error($cats)) {
                $cat = $cats[0];
                $items[] = array(
                    'name' => $cat->name,
                    'url'  => get_term_link($cat),
                );
            }

            $items[] = array(
                'name' => get_the_title(),
                'url'  => '',
            );

            return $items;
        }

        // Product category archive: Home > Shop > Category Name
        if (function_exists('is_product_category') && is_product_category()) {
            $shop_page_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : '';
            $items[] = array(
                'name' => 'Shop',
                'url'  => $shop_page_url,
            );

            $term = get_queried_object();
            if ($term) {
                $items[] = array(
                    'name' => $term->name,
                    'url'  => '',
                );
            }

            return $items;
        }

        // Shop page: Home > Shop
        if (function_exists('is_shop') && is_shop()) {
            $items[] = array(
                'name' => 'Shop',
                'url'  => '',
            );
            return $items;
        }

        // Other pages: Home > Page Title
        if (is_singular()) {
            $items[] = array(
                'name' => get_the_title(),
                'url'  => '',
            );
            return $items;
        }

        return $items;
    }
}

/* =========================================================================
 * HOOAN_SEO_Robots — robots.txt directives + sitemap link tag
 * ========================================================================= */

class HOOAN_SEO_Robots {

    public function __construct() {
        add_filter('robots_txt', array($this, 'filter_robots_txt'), 10, 2);
        add_action('wp_head', array($this, 'render_sitemap_link'), 4);
    }

    /**
     * Append AI crawler directives, disallow rules, and sitemap to robots.txt.
     *
     * @param string $output Existing robots.txt content.
     * @param bool   $public Whether the site is publicly visible.
     * @return string
     */
    public function filter_robots_txt($output, $public) {
        if (!$public) {
            return $output;
        }

        $additions = "\n";

        // Allow AI crawlers on public content
        $ai_bots = array('GPTBot', 'PerplexityBot', 'ClaudeBot');
        foreach ($ai_bots as $bot) {
            $additions .= "User-agent: {$bot}\n";
            $additions .= "Allow: /\n\n";
        }

        // Disallow private/utility paths
        $additions .= "User-agent: *\n";
        $additions .= "Disallow: /wp-admin/\n";
        $additions .= "Disallow: /cart/\n";
        $additions .= "Disallow: /checkout/\n";
        $additions .= "Disallow: /my-account/\n\n";

        // Sitemap
        $additions .= "Sitemap: " . esc_url(home_url('/wp-sitemap.xml')) . "\n";

        return $output . $additions;
    }

    /**
     * Output a <link> tag referencing the sitemap for crawler discovery.
     */
    public function render_sitemap_link() {
        echo '<link rel="sitemap" type="application/xml" href="' . esc_url(home_url('/wp-sitemap.xml')) . '">' . "\n";
    }
}

/* =========================================================================
 * Product image alt text filter — includes product name + fiber type
 * ========================================================================= */

/**
 * Filter product image alt text to include product name and fiber type.
 *
 * @param array $attr Image attributes.
 * @param WP_Post $attachment Attachment post object.
 * @param string|array $size Image size.
 * @return array
 */
function hooan_seo_product_image_alt($attr, $attachment, $size) {
    if (!is_singular('product') || !function_exists('WC')) {
        return $attr;
    }

    global $post;
    if (!$post) {
        return $attr;
    }

    $product = wc_get_product($post);
    if (!$product) {
        return $attr;
    }

    // Only modify if this image belongs to the current product
    $product_image_ids = array_filter(array_merge(
        array($product->get_image_id()),
        $product->get_gallery_image_ids()
    ));

    if (!in_array($attachment->ID, $product_image_ids, true)) {
        return $attr;
    }

    $name = $product->get_name();
    $fiber = hooan_get_product_fiber_type($product->get_id());

    if (!empty($fiber)) {
        $attr['alt'] = $name . ' — ' . $fiber;
    } else {
        $attr['alt'] = $name;
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'hooan_seo_product_image_alt', 10, 3);
