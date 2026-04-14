<?php
/**
 * The template for displaying all pages
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();
?>

<main class="min-h-screen pt-20">
    <?php while (have_posts()) : the_post(); ?>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="prose dark:prose-invert max-w-none">
                <?php the_content(); ?>
            </div>
        </article>
    </div>
    <?php endwhile; ?>
</main>

<?php
get_footer();