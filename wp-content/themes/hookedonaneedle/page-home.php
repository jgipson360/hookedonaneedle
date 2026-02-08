<?php
/**
 * Template Name: Homepage
 *
 * The homepage template that assembles all sections.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();
?>

<main>
    <?php
    // Hero Section
    get_template_part('template-parts/hero-section');

    // Featured Creations Section
    get_template_part('template-parts/featured-creations');

    // Product Features Section
    get_template_part('template-parts/product-features');
    ?>
</main>

<?php
get_footer();
