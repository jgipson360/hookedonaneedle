<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

get_header();
?>

<main class="min-h-screen pt-20">
    <?php if (have_posts()) : ?>
        <div class="max-w-7xl mx-auto px-6 py-12">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('mb-12'); ?>>
                    <header class="mb-6">
                        <h2 class="font-display text-3xl font-semibold">
                            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400 mt-2">
                            <?php echo get_the_date(); ?>
                        </p>
                    </header>
                    <div class="prose dark:prose-invert max-w-none">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>
        </div>
    <?php else : ?>
        <div class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h1 class="font-display text-4xl font-semibold mb-4">Nothing Found</h1>
            <p class="text-slate-600 dark:text-slate-400">
                It seems we can't find what you're looking for.
            </p>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
