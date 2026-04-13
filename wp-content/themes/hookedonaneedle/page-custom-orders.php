<?php
/**
 * Template Name: Custom Orders
 *
 * The Custom Orders page template for commission inquiries.
 * Renders hero, process strip, Gravity Forms multi-step form, and trust bar.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();
?>

<main class="max-w-7xl mx-auto px-6 pt-28 pb-12">
    <?php
    get_template_part('template-parts/custom-orders-hero');
    get_template_part('template-parts/custom-orders-process');
    get_template_part('template-parts/custom-orders-form');
    get_template_part('template-parts/custom-orders-trust');
    ?>
</main>

<?php get_footer(); ?>
