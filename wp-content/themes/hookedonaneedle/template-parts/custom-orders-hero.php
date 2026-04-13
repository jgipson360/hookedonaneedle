<?php
/**
 * Template Part: Custom Orders Hero Section
 *
 * Displays the "Made to Order" label, headline, and description.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$label   = get_field('co_hero_label')   ?: 'Made to Order';
$heading = get_field('co_hero_heading') ?: 'Something made<br><em>just for you.</em>';
$desc    = get_field('co_hero_desc')    ?: "Tell us what you have in mind and we'll bring it to life, stitch by stitch. Most commissions ship within 4 to 6 weeks.";
?>

<section class="custom-orders-hero">
    <p class="custom-orders-hero__label"><?php echo esc_html($label); ?></p>
    <h2 class="custom-orders-hero__heading font-display">
        <?php echo wp_kses_post($heading); ?>
    </h2>
    <p class="custom-orders-hero__desc">
        <?php echo esc_html($desc); ?>
    </p>
</section>
