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
 * Register Social Page ACF Field Group
 *
 * Fields for the Social page template, organized into tabs:
 * Live CTA, Upcoming Events, Community, Hot Drops
 *
 * @since 1.0.0
 */
function hooan_register_social_page_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_social_page_content',
        'title' => 'Social Page Content',
        'fields' => array(
            // =====================
            // LIVE CTA TAB
            // =====================
            array(
                'key' => 'field_social_live_cta_tab',
                'label' => 'Live CTA',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_social_headline_main',
                'label' => 'Headline - Main Text',
                'name' => 'social_headline_main',
                'type' => 'text',
                'instructions' => 'First part of the headline (e.g., "Stitching")',
                'default_value' => 'Stitching',
                'placeholder' => 'Enter main headline text',
            ),
            array(
                'key' => 'field_social_headline_emphasis',
                'label' => 'Headline - Emphasis Text',
                'name' => 'social_headline_emphasis',
                'type' => 'text',
                'instructions' => 'Styled/italic part of the headline (e.g., "Live with")',
                'default_value' => 'Live with',
                'placeholder' => 'Enter emphasis text',
            ),
            array(
                'key' => 'field_social_headline_secondary',
                'label' => 'Headline - Secondary Text',
                'name' => 'social_headline_secondary',
                'type' => 'text',
                'instructions' => 'Final part of the headline (e.g., "Community.")',
                'default_value' => 'Community.',
                'placeholder' => 'Enter secondary text',
            ),
            array(
                'key' => 'field_social_description',
                'label' => 'Description',
                'name' => 'social_description',
                'type' => 'textarea',
                'instructions' => 'Description paragraph below the headline',
                'default_value' => "Join our daily creative session! We're currently working on the 'Sand & Sea' shawl pattern. Ask questions, learn new stitches, or just relax with us.",
                'rows' => 3,
            ),
            array(
                'key' => 'field_social_preview_image',
                'label' => 'Preview Image',
                'name' => 'social_preview_image',
                'type' => 'image',
                'instructions' => 'Featured image for the live CTA section (fallback when no TikTok video URL is set)',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_social_tiktok_video_url',
                'label' => 'TikTok Video URL',
                'name' => 'social_tiktok_video_url',
                'type' => 'text',
                'instructions' => 'Optional: TikTok video URL for embedding (e.g., https://www.tiktok.com/@user/video/123456). Leave empty to show preview image.',
                'placeholder' => 'https://www.tiktok.com/@user/video/123456',
            ),
            array(
                'key' => 'field_social_primary_cta_label',
                'label' => 'Primary CTA Button Label',
                'name' => 'social_primary_cta_label',
                'type' => 'text',
                'default_value' => 'Join Live Now',
                'placeholder' => 'Button text',
            ),
            array(
                'key' => 'field_social_primary_cta_url',
                'label' => 'Primary CTA Button URL',
                'name' => 'social_primary_cta_url',
                'type' => 'url',
                'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_social_secondary_cta_label',
                'label' => 'Secondary CTA Button Label',
                'name' => 'social_secondary_cta_label',
                'type' => 'text',
                'default_value' => 'View All Replays',
                'placeholder' => 'Button text',
            ),
            array(
                'key' => 'field_social_secondary_cta_url',
                'label' => 'Secondary CTA Button URL',
                'name' => 'social_secondary_cta_url',
                'type' => 'url',
                'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_social_tiktok_handle',
                'label' => 'TikTok Handle',
                'name' => 'social_tiktok_handle',
                'type' => 'text',
                'instructions' => 'Display text for TikTok handle on overlay',
                'default_value' => '@hookedonaneedle',
                'placeholder' => '@username',
            ),
            array(
                'key' => 'field_social_viewer_count',
                'label' => 'Viewer Count Text',
                'name' => 'social_viewer_count',
                'type' => 'text',
                'instructions' => 'Display text for viewer count on overlay',
                'default_value' => '1.2k watching',
                'placeholder' => 'e.g., 1.2k watching',
            ),

            // =====================
            // UPCOMING EVENTS TAB
            // =====================
            array(
                'key' => 'field_social_events_tab',
                'label' => 'Upcoming Events',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_social_events_title',
                'label' => 'Section Title',
                'name' => 'social_events_title',
                'type' => 'text',
                'default_value' => 'Upcoming Events',
            ),
            array(
                'key' => 'field_social_events_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'social_events_subtitle',
                'type' => 'text',
                'default_value' => 'Join our scheduled crochet-alongs and masterclasses',
            ),
            array(
                'key' => 'field_social_events',
                'label' => 'Events',
                'name' => 'social_events',
                'type' => 'repeater',
                'instructions' => 'Add upcoming events. Drag to reorder.',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Add Event',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_event_date',
                        'label' => 'Event Date',
                        'name' => 'event_date',
                        'type' => 'date_picker',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'Ymd',
                    ),
                    array(
                        'key' => 'field_social_event_title',
                        'label' => 'Event Title',
                        'name' => 'event_title',
                        'type' => 'text',
                        'placeholder' => 'e.g., Heirloom Blanket CAL',
                    ),
                    array(
                        'key' => 'field_social_event_description',
                        'label' => 'Event Description',
                        'name' => 'event_description',
                        'type' => 'text',
                        'placeholder' => 'Brief description of the event',
                    ),
                    array(
                        'key' => 'field_social_event_time',
                        'label' => 'Event Time',
                        'name' => 'event_time',
                        'type' => 'text',
                        'placeholder' => 'e.g., 6:00 PM EST',
                    ),
                ),
            ),

            // =====================
            // COMMUNITY TAB
            // =====================
            array(
                'key' => 'field_social_community_tab',
                'label' => 'Community',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_social_community_heading',
                'label' => 'Section Heading',
                'name' => 'social_community_heading',
                'type' => 'text',
                'default_value' => 'Join the Community',
            ),
            array(
                'key' => 'field_social_community_name',
                'label' => 'Community Name',
                'name' => 'social_community_name',
                'type' => 'text',
                'default_value' => 'The Stitch Squad',
            ),
            array(
                'key' => 'field_social_community_description',
                'label' => 'Community Description',
                'name' => 'social_community_description',
                'type' => 'textarea',
                'default_value' => 'Discover daily inspiration, viral tutorials, and behind-the-scenes magic with our vibrant creator community on TikTok.',
                'rows' => 3,
            ),
            array(
                'key' => 'field_social_tiktok_url',
                'label' => 'TikTok Profile URL',
                'name' => 'social_tiktok_url',
                'type' => 'url',
                'instructions' => 'URL to your TikTok profile',
                'default_value' => 'https://www.tiktok.com/@hookedonaneedle',
            ),
            array(
                'key' => 'field_social_member_count',
                'label' => 'Member Count Badge',
                'name' => 'social_member_count',
                'type' => 'text',
                'instructions' => 'Text displayed in the member count badge',
                'default_value' => '+1.5k',
            ),
            array(
                'key' => 'field_social_member_avatars',
                'label' => 'Member Avatars',
                'name' => 'social_member_avatars',
                'type' => 'repeater',
                'instructions' => 'Add community member avatar images (recommended: 3-4 images)',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add Avatar',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_avatar_image',
                        'label' => 'Avatar Image',
                        'name' => 'avatar',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                    ),
                ),
            ),

            // =====================
            // HOT DROPS TAB
            // =====================
            array(
                'key' => 'field_social_hotdrops_tab',
                'label' => 'Hot Drops',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_social_hotdrops_heading',
                'label' => 'Section Heading',
                'name' => 'social_hotdrops_heading',
                'type' => 'text',
                'default_value' => 'Hot Drops',
            ),
            array(
                'key' => 'field_social_hotdrops_follow_text',
                'label' => 'Follow Link Text',
                'name' => 'social_hotdrops_follow_text',
                'type' => 'text',
                'default_value' => 'Follow @hookedonaneedle',
            ),
            array(
                'key' => 'field_social_hotdrops_follow_url',
                'label' => 'Follow Link URL',
                'name' => 'social_hotdrops_follow_url',
                'type' => 'url',
                'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_social_hotdrops_items',
                'label' => 'Hot Drops Items',
                'name' => 'social_hotdrops_items',
                'type' => 'repeater',
                'instructions' => 'Add hot drop items. The last item will show a "Shop Now" hover overlay.',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Add Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_hotdrop_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                    ),
                    array(
                        'key' => 'field_social_hotdrop_alt_text',
                        'label' => 'Alt Text',
                        'name' => 'alt_text',
                        'type' => 'text',
                        'placeholder' => 'Image description for accessibility',
                    ),
                    array(
                        'key' => 'field_social_hotdrop_link_url',
                        'label' => 'Link URL (Optional)',
                        'name' => 'link_url',
                        'type' => 'url',
                        'instructions' => 'Optional link for this item',
                        'placeholder' => 'https://',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-social.php',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_social_page_acf_fields');

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
            array('label' => 'Our Story', 'url' => home_url('/about')),
            array('label' => 'Shop', 'url' => home_url('/shop')),
            array('label' => 'Learn', 'url' => home_url('/learn')),
        ),
        'support_links' => array(
            array('label' => 'Custom Orders', 'url' => home_url('/custom-orders')),
            array('label' => 'Social Hub', 'url' => home_url('/social')),
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

/**
 * Register ACF field group for WooCommerce Product Details
 */
function hooan_register_product_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_product_details',
        'title' => 'Product Details',
        'fields' => array(
            array(
                'key' => 'field_product_fiber_type',
                'label' => 'Fiber / Yarn Type',
                'name' => 'fiber_yarn_type',
                'type' => 'text',
                'instructions' => 'Yarn or fiber composition (e.g., "100% Organic Cotton")',
                'placeholder' => 'Enter fiber/yarn type',
            ),
            array(
                'key' => 'field_product_care_instructions',
                'label' => 'Care Instructions',
                'name' => 'care_instructions',
                'type' => 'textarea',
                'instructions' => 'Washing and maintenance guidance',
                'rows' => 3,
                'placeholder' => 'e.g., Hand wash cold, lay flat to dry',
            ),
            array(
                'key' => 'field_product_difficulty_level',
                'label' => 'Difficulty Level',
                'name' => 'difficulty_level',
                'type' => 'select',
                'instructions' => 'Crochet difficulty level of the pattern/product',
                'choices' => array(
                    'beginner'     => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced'     => 'Advanced',
                ),
                'default_value' => 'beginner',
                'allow_null' => 1,
                'return_format' => 'label',
            ),
            array(
                'key' => 'field_product_made_to_order',
                'label' => 'Made to Order',
                'name' => 'made_to_order',
                'type' => 'true_false',
                'instructions' => 'Enable if this product is made after purchase (not from existing stock)',
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_product_turnaround_time',
                'label' => 'Estimated Turnaround Time',
                'name' => 'turnaround_time',
                'type' => 'text',
                'instructions' => 'Production time estimate (e.g., "2-3 weeks")',
                'placeholder' => 'e.g., 2-3 weeks',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_product_made_to_order',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_product_badge',
                'label' => 'Product Badge',
                'name' => 'product_badge',
                'type' => 'select',
                'instructions' => 'Optional badge overlay on the product card image',
                'choices' => array(
                    'none'         => 'None',
                    'limited_drop' => 'Limited Drop',
                    'one_of_one'   => 'One of One',
                ),
                'default_value' => 'none',
                'allow_null' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_product_acf_fields');

/**
 * Register Custom Orders ACF field group.
 */
function hooan_register_custom_orders_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_custom_orders_content',
        'title' => 'Custom Orders Content',
        'fields' => array(
            // =====================
            // HERO SECTION TAB
            // =====================
            array(
                'key' => 'field_co_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_co_hero_label',
                'label' => 'Label',
                'name' => 'co_hero_label',
                'type' => 'text',
                'instructions' => 'Small label above the headline.',
                'default_value' => 'Made to Order',
            ),
            array(
                'key' => 'field_co_hero_heading',
                'label' => 'Heading',
                'name' => 'co_hero_heading',
                'type' => 'textarea',
                'instructions' => 'Supports HTML (&lt;br&gt;, &lt;em&gt;).',
                'default_value' => 'Something made<br><em>just for you.</em>',
                'rows' => 3,
            ),
            array(
                'key' => 'field_co_hero_desc',
                'label' => 'Description',
                'name' => 'co_hero_desc',
                'type' => 'textarea',
                'default_value' => "Tell us what you have in mind and we'll bring it to life, stitch by stitch. Most commissions ship within 4 to 6 weeks.",
                'rows' => 3,
            ),

            // =====================
            // PROCESS STEPS TAB
            // =====================
            array(
                'key' => 'field_co_process_tab',
                'label' => 'Process Steps',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_co_process_steps',
                'label' => 'Steps',
                'name' => 'co_process_steps',
                'type' => 'repeater',
                'instructions' => 'The commission process steps displayed on the page.',
                'min' => 0,
                'max' => 10,
                'layout' => 'table',
                'button_label' => 'Add Step',
                'sub_fields' => array(
                    array(
                        'key' => 'field_co_step_num',
                        'label' => 'Number',
                        'name' => 'num',
                        'type' => 'text',
                        'wrapper' => array('width' => '15'),
                    ),
                    array(
                        'key' => 'field_co_step_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_co_step_desc',
                        'label' => 'Description',
                        'name' => 'desc',
                        'type' => 'text',
                        'wrapper' => array('width' => '60'),
                    ),
                ),
            ),

            // =====================
            // FORM OPTIONS TAB
            // =====================
            array(
                'key' => 'field_co_form_tab',
                'label' => 'Form Options',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_co_form_categories',
                'label' => 'Categories',
                'name' => 'co_form_categories',
                'type' => 'textarea',
                'instructions' => 'One category per line.',
                'default_value' => "Blanket or Throw\nCardigan or Sweater\nHat or Beanie\nBaby Items\nHome Decor\nPlushie or Novelty\nTote or Bag\nSomething else",
                'rows' => 8,
            ),
            array(
                'key' => 'field_co_form_colors',
                'label' => 'Color Swatches',
                'name' => 'co_form_colors',
                'type' => 'repeater',
                'instructions' => 'Colors shown as swatches in the form.',
                'min' => 0,
                'max' => 20,
                'layout' => 'table',
                'button_label' => 'Add Color',
                'sub_fields' => array(
                    array(
                        'key' => 'field_co_color_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_co_color_hex',
                        'label' => 'Hex',
                        'name' => 'hex',
                        'type' => 'text',
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),
            array(
                'key' => 'field_co_form_materials',
                'label' => 'Materials',
                'name' => 'co_form_materials',
                'type' => 'textarea',
                'instructions' => 'One material per line.',
                'default_value' => "Wool\nCotton\nAcrylic\nAlpaca\nOrganic / Natural\nNo preference",
                'rows' => 6,
            ),

            // =====================
            // TRUST BAR TAB
            // =====================
            array(
                'key' => 'field_co_trust_tab',
                'label' => 'Trust Bar',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_co_trust_items',
                'label' => 'Trust Items',
                'name' => 'co_trust_items',
                'type' => 'repeater',
                'instructions' => 'Trust signals displayed at the bottom of the page.',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_co_trust_value',
                        'label' => 'Value',
                        'name' => 'value',
                        'type' => 'text',
                        'wrapper' => array('width' => '50'),
                    ),
                    array(
                        'key' => 'field_co_trust_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-custom-orders.php',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_custom_orders_acf_fields');

/**
 * Register About Page ACF field group
 */
function hooan_register_about_page_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_about_page_content',
        'title' => 'About Page Content',
        'fields' => array(
            // ── HERO SECTION TAB ──
            array(
                'key' => 'field_about_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_about_hero_label',
                'label' => 'Tagline Label',
                'name' => 'about_hero_label',
                'type' => 'text',
                'instructions' => 'Short label above the headline (e.g., "The Hands & Heart")',
                'default_value' => 'The Hands & Heart',
            ),
            array(
                'key' => 'field_about_hero_heading',
                'label' => 'Headline',
                'name' => 'about_hero_heading',
                'type' => 'textarea',
                'instructions' => 'Main headline. Supports &lt;br&gt; for line breaks and &lt;em&gt; for italic/primary color.',
                'default_value' => 'Hi, I\'m Jamila —<br/>The Heart Behind<br/><em>Hooked on a Needle</em>',
                'rows' => 3,
            ),
            array(
                'key' => 'field_about_hero_quote',
                'label' => 'Pull Quote',
                'name' => 'about_hero_quote',
                'type' => 'textarea',
                'instructions' => 'Italic quote displayed below the divider.',
                'default_value' => '"I didn\'t just learn how to crochet… I was introduced to a rhythm. A rhythm of patience. Of creativity. Of healing."',
                'rows' => 3,
            ),
            array(
                'key' => 'field_about_hero_image',
                'label' => 'Hero Image',
                'name' => 'about_hero_image',
                'type' => 'image',
                'instructions' => 'Portrait photo of the founder. Falls back to the default if empty.',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // ── STORY SECTION TAB ──
            array(
                'key' => 'field_about_story_tab',
                'label' => 'Story Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_about_story_opener',
                'label' => 'Opener Paragraph',
                'name' => 'about_story_opener',
                'type' => 'textarea',
                'instructions' => 'Opening statement. Supports &lt;em&gt; for italic/primary color emphasis.',
                'default_value' => 'Hooked on a Needle was born from more than yarn — it was born from <em>purpose.</em>',
                'rows' => 2,
            ),
            array(
                'key' => 'field_about_story_body',
                'label' => 'Body Text',
                'name' => 'about_story_body',
                'type' => 'textarea',
                'instructions' => 'Main story body text. Supports &lt;strong&gt; for bold highlights.',
                'default_value' => 'As a <strong>self-taught Fiber-Arts Engineer</strong>, my journey with yarn is rooted in the fusion of artistic expression and structural integrity. I don\'t just create accessories — I engineer pieces that balance <strong>texture, structure, durability, and design</strong>.',
                'rows' => 4,
            ),
            array(
                'key' => 'field_about_story_quote',
                'label' => 'Pull Quote',
                'name' => 'about_story_quote',
                'type' => 'textarea',
                'instructions' => 'Blockquote displayed with a left border accent.',
                'default_value' => 'When you support Hooked on a Needle, you\'re not just buying a handmade item — you\'re investing in a legacy of craftsmanship and a commitment to a slow, intentional way of living.',
                'rows' => 3,
            ),

            // ── VALUES TAB ──
            array(
                'key' => 'field_about_values_tab',
                'label' => 'Values',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_about_values_label',
                'label' => 'Section Label',
                'name' => 'about_values_label',
                'type' => 'text',
                'default_value' => 'Beyond Craftsmanship',
            ),
            array(
                'key' => 'field_about_values_intro',
                'label' => 'Intro Text',
                'name' => 'about_values_intro',
                'type' => 'textarea',
                'default_value' => 'My vision extends beyond hooks and needles. I am committed to fostering a community built on growth and empowerment.',
                'rows' => 2,
            ),
            array(
                'key' => 'field_about_values',
                'label' => 'Values',
                'name' => 'about_values',
                'type' => 'repeater',
                'instructions' => 'Core values displayed as numbered rows.',
                'min' => 0,
                'max' => 10,
                'layout' => 'block',
                'button_label' => 'Add Value',
                'sub_fields' => array(
                    array(
                        'key' => 'field_about_value_num',
                        'label' => 'Number',
                        'name' => 'num',
                        'type' => 'text',
                        'wrapper' => array('width' => '15'),
                    ),
                    array(
                        'key' => 'field_about_value_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '20'),
                    ),
                    array(
                        'key' => 'field_about_value_heading',
                        'label' => 'Heading',
                        'name' => 'heading',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_about_value_body',
                        'label' => 'Body',
                        'name' => 'body',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => array('width' => '40'),
                    ),
                ),
            ),

            // ── MISSION TAB ──
            array(
                'key' => 'field_about_mission_tab',
                'label' => 'Mission',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_about_mission_quote',
                'label' => 'Mission Quote',
                'name' => 'about_mission_quote',
                'type' => 'textarea',
                'instructions' => 'Centered blockquote. Supports &lt;em&gt; for italic/primary color emphasis.',
                'default_value' => '"My mission is simple: to <em>stitch warmth,</em> beauty, and purpose into everything I touch."',
                'rows' => 2,
            ),

            // ── SIGN-OFF TAB ──
            array(
                'key' => 'field_about_sign_tab',
                'label' => 'Sign-Off',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_about_sign_intro',
                'label' => 'Intro Text',
                'name' => 'about_sign_intro',
                'type' => 'textarea',
                'default_value' => 'Thank you for being here, for appreciating the art of the slow stitch, and for being part of this beautiful journey.',
                'rows' => 2,
            ),
            array(
                'key' => 'field_about_sign_close',
                'label' => 'Closing Line',
                'name' => 'about_sign_close',
                'type' => 'text',
                'default_value' => 'With love & loops,',
            ),
            array(
                'key' => 'field_about_sign_name',
                'label' => 'Signature Name',
                'name' => 'about_sign_name',
                'type' => 'text',
                'default_value' => 'Jamila',
            ),
            array(
                'key' => 'field_about_sign_founder',
                'label' => 'Founder Title',
                'name' => 'about_sign_founder',
                'type' => 'text',
                'default_value' => 'Founder, Hooked on a Needle LLC',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about.php',
                ),
            ),
        ),
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_about_page_acf_fields');

/**
 * Register Learn Page ACF Field Group
 *
 * Fields for the Learn page template (Hats for the Homeless), organized into tabs:
 * Hero, Mission, Distribution, Narrative, Get Involved, Location
 *
 * @since 1.0.0
 */
function hooan_register_learn_page_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_learn_page_content',
        'title' => 'Learn Page Content',
        'fields' => array(
            // ── HERO TAB ──
            array(
                'key' => 'field_learn_hero_tab',
                'label' => 'Hero',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_hero_label',
                'label' => 'Hero Label',
                'name' => 'learn_hero_label',
                'type' => 'text',
                'instructions' => 'Small label text above the headline.',
                'default_value' => 'A Community Initiative',
            ),
            array(
                'key' => 'field_learn_hero_heading',
                'label' => 'Hero Heading',
                'name' => 'learn_hero_heading',
                'type' => 'textarea',
                'instructions' => 'Headline text. Supports &lt;br&gt; and &lt;em&gt; HTML tags.',
                'default_value' => 'Hats for the<br/><em>Homeless</em>',
                'rows' => 2,
            ),
            array(
                'key' => 'field_learn_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'learn_hero_subtitle',
                'type' => 'text',
                'instructions' => 'Subtitle text below the headline.',
                'default_value' => 'A Hooked on a Needle Community Initiative',
            ),
            array(
                'key' => 'field_learn_hero_cta_text',
                'label' => 'Hero CTA Text',
                'name' => 'learn_hero_cta_text',
                'type' => 'text',
                'instructions' => 'Call-to-action button label.',
                'default_value' => 'Explore Our Impact',
            ),
            array(
                'key' => 'field_learn_hero_image',
                'label' => 'Hero Background Image',
                'name' => 'learn_hero_image',
                'type' => 'image',
                'instructions' => 'Full-width background image for the hero section.',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // ── MISSION TAB ──
            array(
                'key' => 'field_learn_mission_tab',
                'label' => 'Mission',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_mission_quote',
                'label' => 'Mission Quote',
                'name' => 'learn_mission_quote',
                'type' => 'textarea',
                'instructions' => 'Centered quote text. Supports &lt;em&gt; for emphasis.',
                'default_value' => '"At Hooked on a Needle, crochet is more than craft — it\'s <em>a thread of hope.</em> Our mission is to weave compassion into every stitch, providing warmth and dignity to those who need it most."',
                'rows' => 3,
            ),

            // ── DISTRIBUTION TAB ──
            array(
                'key' => 'field_learn_dist_tab',
                'label' => 'Distribution',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_dist_label',
                'label' => 'Section Label',
                'name' => 'learn_dist_label',
                'type' => 'text',
                'default_value' => 'Community Support',
            ),
            array(
                'key' => 'field_learn_dist_heading',
                'label' => 'Section Heading',
                'name' => 'learn_dist_heading',
                'type' => 'text',
                'default_value' => 'What we distribute',
            ),
            array(
                'key' => 'field_learn_dist_items',
                'label' => 'Distribution Items',
                'name' => 'learn_dist_items',
                'type' => 'repeater',
                'instructions' => 'Items distributed by the initiative. Each row: icon name, title, description.',
                'min' => 0,
                'max' => 8,
                'layout' => 'block',
                'button_label' => 'Add Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_learn_dist_item_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'text',
                        'instructions' => 'Material Icons Outlined name (e.g., headset_off, front_hand).',
                        'wrapper' => array('width' => '20'),
                    ),
                    array(
                        'key' => 'field_learn_dist_item_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '30'),
                    ),
                    array(
                        'key' => 'field_learn_dist_item_desc',
                        'label' => 'Description',
                        'name' => 'desc',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => array('width' => '50'),
                    ),
                ),
            ),

            // ── NARRATIVE TAB ──
            array(
                'key' => 'field_learn_narr_tab',
                'label' => 'Narrative',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_narr_heading',
                'label' => 'Heading',
                'name' => 'learn_narr_heading',
                'type' => 'text',
                'default_value' => 'Human connection in the heart of Fort Worth',
            ),
            array(
                'key' => 'field_learn_narr_body_1',
                'label' => 'Body Paragraph 1',
                'name' => 'learn_narr_body_1',
                'type' => 'textarea',
                'instructions' => 'First body paragraph. Supports HTML.',
                'default_value' => 'Since our inception, Hooked on a Needle has looked beyond the luxury of high-end fiber arts to address the raw realities of our local community. Based in Fort Worth, our philanthropy is centered on the belief that a handmade item carries a weight of care that a mass-produced product cannot.',
                'rows' => 3,
            ),
            array(
                'key' => 'field_learn_narr_body_2',
                'label' => 'Body Paragraph 2',
                'name' => 'learn_narr_body_2',
                'type' => 'textarea',
                'instructions' => 'Second body paragraph. Supports HTML.',
                'default_value' => 'When we hand a hat to someone on the street, we aren\'t just giving them wool — we are giving them a piece of time, a symbol of dignity, and the knowledge that they are seen.',
                'rows' => 3,
            ),
            array(
                'key' => 'field_learn_narr_quote',
                'label' => 'Pull Quote',
                'name' => 'learn_narr_quote',
                'type' => 'textarea',
                'default_value' => '"Every stitch represents a moment where someone was thinking of their neighbor."',
                'rows' => 2,
            ),
            array(
                'key' => 'field_learn_narr_stat_num',
                'label' => 'Stat Number',
                'name' => 'learn_narr_stat_num',
                'type' => 'text',
                'instructions' => 'Large stat number on the badge (e.g., 5,000+).',
                'default_value' => '5,000+',
            ),
            array(
                'key' => 'field_learn_narr_stat_label',
                'label' => 'Stat Label',
                'name' => 'learn_narr_stat_label',
                'type' => 'text',
                'instructions' => 'Description below the stat number.',
                'default_value' => 'Hats distributed across the Fort Worth community since 2021.',
            ),
            array(
                'key' => 'field_learn_narr_image',
                'label' => 'Narrative Image',
                'name' => 'learn_narr_image',
                'type' => 'image',
                'instructions' => 'Image displayed beside the narrative text (recommended 4:5 aspect ratio).',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // ── GET INVOLVED TAB ──
            array(
                'key' => 'field_learn_involve_tab',
                'label' => 'Get Involved',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_involve_label',
                'label' => 'Section Label',
                'name' => 'learn_involve_label',
                'type' => 'text',
                'default_value' => 'Get Involved',
            ),
            array(
                'key' => 'field_learn_involve_heading',
                'label' => 'Section Heading',
                'name' => 'learn_involve_heading',
                'type' => 'text',
                'default_value' => 'Ways to make a difference',
            ),
            array(
                'key' => 'field_learn_involve_intro',
                'label' => 'Intro Text',
                'name' => 'learn_involve_intro',
                'type' => 'textarea',
                'default_value' => 'Whether you have five minutes, a stash of yarn, or a desire to give financially, there is a place for you here.',
                'rows' => 2,
            ),
            array(
                'key' => 'field_learn_involve_cards',
                'label' => 'Involvement Cards',
                'name' => 'learn_involve_cards',
                'type' => 'repeater',
                'instructions' => 'Cards for the involvement section. Toggle "Featured" for the highlighted card.',
                'min' => 0,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Card',
                'sub_fields' => array(
                    array(
                        'key' => 'field_learn_involve_card_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => array('width' => '25'),
                    ),
                    array(
                        'key' => 'field_learn_involve_card_body',
                        'label' => 'Body',
                        'name' => 'body',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => array('width' => '35'),
                    ),
                    array(
                        'key' => 'field_learn_involve_card_link_text',
                        'label' => 'Link Text',
                        'name' => 'link_text',
                        'type' => 'text',
                        'wrapper' => array('width' => '15'),
                    ),
                    array(
                        'key' => 'field_learn_involve_card_link_url',
                        'label' => 'Link URL',
                        'name' => 'link_url',
                        'type' => 'url',
                        'wrapper' => array('width' => '15'),
                    ),
                    array(
                        'key' => 'field_learn_involve_card_featured',
                        'label' => 'Featured',
                        'name' => 'featured',
                        'type' => 'true_false',
                        'instructions' => 'Highlight this card.',
                        'wrapper' => array('width' => '10'),
                    ),
                ),
            ),

            // ── LOCATION TAB ──
            array(
                'key' => 'field_learn_loc_tab',
                'label' => 'Location',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_learn_loc_heading',
                'label' => 'Heading',
                'name' => 'learn_loc_heading',
                'type' => 'text',
                'default_value' => 'Visit our workshop',
            ),
            array(
                'key' => 'field_learn_loc_desc',
                'label' => 'Description',
                'name' => 'learn_loc_desc',
                'type' => 'textarea',
                'default_value' => 'Our Fort Worth creative studio doubles as our distribution hub. Join us for community stitch nights every Thursday.',
                'rows' => 2,
            ),
            array(
                'key' => 'field_learn_loc_address',
                'label' => 'Map Address',
                'name' => 'learn_loc_address',
                'type' => 'text',
                'instructions' => 'Address used for the embedded map. URL-encoded automatically.',
                'default_value' => '402 Magnolia Avenue, Fort Worth, TX 76104',
            ),
            array(
                'key' => 'field_learn_loc_details',
                'label' => 'Location Details',
                'name' => 'learn_loc_details',
                'type' => 'repeater',
                'instructions' => 'Detail rows displayed alongside the map.',
                'min' => 0,
                'max' => 4,
                'layout' => 'table',
                'button_label' => 'Add Detail',
                'sub_fields' => array(
                    array(
                        'key' => 'field_learn_loc_detail_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'text',
                        'instructions' => 'Material Icons Outlined name.',
                    ),
                    array(
                        'key' => 'field_learn_loc_detail_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_learn_loc_detail_body',
                        'label' => 'Body',
                        'name' => 'body',
                        'type' => 'text',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-learn.php',
                ),
            ),
        ),
        'menu_order' => 4,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));
}
add_action('acf/init', 'hooan_register_learn_page_acf_fields');
