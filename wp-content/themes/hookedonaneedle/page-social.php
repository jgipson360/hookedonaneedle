<?php
/**
 * Template Name: Social
 *
 * The Social page template that assembles the Social Hub & Live Events sections.
 * Includes Live CTA, Upcoming Events, Community CTA, and Hot Drops grid.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();
?>

<main class="max-w-7xl mx-auto px-6 pt-28 pb-12">
    <?php
    // Live CTA Section (hero-like)
    get_template_part('template-parts/social-live-cta');

    // Upcoming Events Section
    get_template_part('template-parts/social-events');
    ?>

    <!-- Community + Hot Drops: 2-column grid on desktop, stacked on mobile -->
    <section class="grid md:grid-cols-2 gap-12 mb-20">
        <?php
        // Community TikTok CTA Section
        get_template_part('template-parts/social-community');

        // Hot Drops Grid Section
        get_template_part('template-parts/social-hot-drops');
        ?>
    </section>
</main>

<?php
get_footer();
