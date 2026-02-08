<?php
/**
 * ACF Field Group Definitions
 *
 * Registers all ACF field groups for the homepage content.
 * Fields are organized into tabs: Hero, Featured Creations, Product Features, Footer
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register ACF field groups
 *
 * Only runs if ACF is active.
 */
function hooan_register_acf_fields() {
    // Check if ACF function exists
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    /**
     * Homepage Content Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_homepage_content',
        'title' => 'Homepage Content',
        'fields' => array(
            // =====================
            // HERO SECTION TAB
            // =====================
            array(
                'key' => 'field_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_announcement_badge',
                'label' => 'Announcement Badge',
                'name' => 'announcement_badge',
                'type' => 'text',
                'instructions' => 'Short announcement text that appears above the headline (e.g., "Coming Soon: Fall Collection 2024")',
                'default_value' => 'Coming Soon: Fall Collection 2024',
                'placeholder' => 'Enter announcement text',
            ),
            array(
                'key' => 'field_headline_main',
                'label' => 'Headline - Main Text',
                'name' => 'headline_main',
                'type' => 'text',
                'instructions' => 'First line of the headline',
                'default_value' => 'Intentional design.',
                'placeholder' => 'Enter main headline',
            ),
            array(
                'key' => 'field_headline_emphasis',
                'label' => 'Headline - Emphasis Text',
                'name' => 'headline_emphasis',
                'type' => 'text',
                'instructions' => 'Second line of the headline (displayed in italic/primary color)',
                'default_value' => 'Limited drops.',
                'placeholder' => 'Enter emphasis text',
            ),
            array(
                'key' => 'field_headline_secondary',
                'label' => 'Headline - Secondary Text',
                'name' => 'headline_secondary',
                'type' => 'text',
                'instructions' => 'Third line of the headline',
                'default_value' => 'Custom orders.',
                'placeholder' => 'Enter secondary text',
            ),
            array(
                'key' => 'field_subtitle',
                'label' => 'Subtitle',
                'name' => 'subtitle',
                'type' => 'textarea',
                'instructions' => 'Tagline text below the headline',
                'default_value' => "Community crochet moments start here. We're stitching something special just for you. Sign up to be first in line when the doors open.",
                'rows' => 3,
            ),
            array(
                'key' => 'field_hero_image',
                'label' => 'Hero Featured Image',
                'name' => 'hero_image',
                'type' => 'image',
                'instructions' => 'Featured image displayed on the right side of the hero section (recommended: 1200x1600px)',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // =============================
            // FEATURED CREATIONS TAB
            // =============================
            array(
                'key' => 'field_featured_tab',
                'label' => 'Featured Creations',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_featured_section_title',
                'label' => 'Section Title',
                'name' => 'featured_section_title',
                'type' => 'text',
                'default_value' => 'Featured Creations',
            ),
            array(
                'key' => 'field_featured_section_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'featured_section_subtitle',
                'type' => 'text',
                'default_value' => "Handmade crochet goods you'll love for a lifetime.",
            ),
            array(
                'key' => 'field_featured_lookbook_link',
                'label' => 'Lookbook Link URL',
                'name' => 'featured_lookbook_link',
                'type' => 'url',
                'instructions' => 'Link to the full lookbook page',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_featured_creations',
                'label' => 'Featured Creations',
                'name' => 'featured_creations',
                'type' => 'repeater',
                'instructions' => 'Add featured creation items (recommended: 3 items)',
                'min' => 0,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Creation',
                'sub_fields' => array(
                    array(
                        'key' => 'field_creation_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'instructions' => 'Recommended size: 800x1000px',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ),
                    array(
                        'key' => 'field_creation_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'e.g., Sustainable Fashion',
                    ),
                    array(
                        'key' => 'field_creation_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 2,
                        'placeholder' => 'Brief description of this creation category',
                    ),
                ),
            ),

            // =============================
            // PRODUCT FEATURES TAB
            // =============================
            array(
                'key' => 'field_features_tab',
                'label' => 'Product Features',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_features_quote',
                'label' => 'Features Quote',
                'name' => 'features_quote',
                'type' => 'textarea',
                'instructions' => 'Inspirational quote displayed in this section',
                'default_value' => "\"We're stitching something special just for you.\"",
                'rows' => 2,
            ),
            array(
                'key' => 'field_feature_highlights',
                'label' => 'Feature Highlights',
                'name' => 'feature_highlights',
                'type' => 'repeater',
                'instructions' => 'Key product features/values (recommended: 4 items)',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add Feature',
                'sub_fields' => array(
                    array(
                        'key' => 'field_feature_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'e.g., 100%',
                    ),
                    array(
                        'key' => 'field_feature_subtitle',
                        'label' => 'Subtitle',
                        'name' => 'subtitle',
                        'type' => 'text',
                        'placeholder' => 'e.g., Handmade',
                    ),
                ),
            ),

            // =============================
            // FOOTER TAB
            // =============================
            array(
                'key' => 'field_footer_tab',
                'label' => 'Footer',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_footer_description',
                'label' => 'Footer Description',
                'name' => 'footer_description',
                'type' => 'textarea',
                'instructions' => 'Short description in the footer',
                'default_value' => 'Cozy crochet for comfort, gifting, and everyday warmth. Based in our humble studio, stitching with love.',
                'rows' => 3,
            ),
            array(
                'key' => 'field_social_links',
                'label' => 'Social Media Links',
                'name' => 'social_links',
                'type' => 'repeater',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add Social Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'select',
                        'choices' => array(
                            'instagram' => 'Instagram',
                            'email' => 'Email',
                            'pinterest' => 'Pinterest',
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter/X',
                        ),
                    ),
                    array(
                        'key' => 'field_social_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            array(
                'key' => 'field_explore_links',
                'label' => 'Explore Links',
                'name' => 'explore_links',
                'type' => 'repeater',
                'instructions' => 'Links for the "Explore" footer column',
                'min' => 0,
                'max' => 8,
                'layout' => 'table',
                'button_label' => 'Add Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_explore_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_explore_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            array(
                'key' => 'field_support_links',
                'label' => 'Support Links',
                'name' => 'support_links',
                'type' => 'repeater',
                'instructions' => 'Links for the "Support" footer column',
                'min' => 0,
                'max' => 8,
                'layout' => 'table',
                'button_label' => 'Add Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_support_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_support_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            array(
                'key' => 'field_copyright_text',
                'label' => 'Copyright Text',
                'name' => 'copyright_text',
                'type' => 'text',
                'default_value' => '© 2024 Hooked On A Needle LLC. All rights reserved.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-home.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_acf_fields');

/**
 * Set default ACF values for homepage fields
 *
 * Provides fallback values when fields are empty.
 */
function hooan_get_homepage_defaults() {
    return array(
        'announcement_badge' => 'Coming Soon: Fall Collection 2024',
        'headline_main' => 'Intentional design.',
        'headline_emphasis' => 'Limited drops.',
        'headline_secondary' => 'Custom orders.',
        'subtitle' => "Community crochet moments start here. We're stitching something special just for you. Sign up to be first in line when the doors open.",
        'featured_section_title' => 'Featured Creations',
        'featured_section_subtitle' => "Handmade crochet goods you'll love for a lifetime.",
        'features_quote' => "\"We're stitching something special just for you.\"",
        'footer_description' => 'Cozy crochet for comfort, gifting, and everyday warmth. Based in our humble studio, stitching with love.',
        'copyright_text' => '© ' . date('Y') . ' Hooked On A Needle LLC. All rights reserved.',
        'feature_highlights' => array(
            array('title' => '100%', 'subtitle' => 'Handmade'),
            array('title' => 'Ethical', 'subtitle' => 'Sourcing'),
            array('title' => 'Custom', 'subtitle' => 'Created'),
            array('title' => 'Pure', 'subtitle' => 'Cotton/Wool'),
        ),
        'featured_creations' => array(
            array(
                'title' => 'Sustainable Fashion',
                'description' => 'Artisan wearables designed for comfort and everyday warmth.',
                'image' => null,
            ),
            array(
                'title' => 'Heirloom Blankets',
                'description' => 'Intricate patterns meeting ultra-soft fibers for ultimate cozy moments.',
                'image' => null,
            ),
            array(
                'title' => 'Novelty & Gifting',
                'description' => 'Whimsical amigurumi and unique home accents for special gifting.',
                'image' => null,
            ),
        ),
        'explore_links' => array(
            array('label' => 'Our Story', 'url' => '#'),
            array('label' => 'The Process', 'url' => '#'),
            array('label' => 'Care Instructions', 'url' => '#'),
            array('label' => 'Blog', 'url' => '#'),
        ),
        'support_links' => array(
            array('label' => 'Contact Us', 'url' => '#'),
            array('label' => 'Shipping Policy', 'url' => '#'),
            array('label' => 'Returns & Exchanges', 'url' => '#'),
            array('label' => 'Privacy', 'url' => '#'),
        ),
        'social_links' => array(
            array('icon' => 'instagram', 'url' => '#'),
            array('icon' => 'email', 'url' => '#'),
            array('icon' => 'pinterest', 'url' => '#'),
        ),
    );
}

/**
 * Get ACF field value with fallback to default
 *
 * @param string $field_name ACF field name
 * @param mixed $post_id Post ID (optional)
 * @return mixed Field value or default
 */
function hooan_get_field($field_name, $post_id = false) {
    $value = null;

    // Try to get ACF field value
    if (function_exists('get_field')) {
        $value = get_field($field_name, $post_id);
    }

    // If empty, return default
    if (empty($value)) {
        $defaults = hooan_get_homepage_defaults();
        if (isset($defaults[$field_name])) {
            return $defaults[$field_name];
        }
    }

    return $value;
}
