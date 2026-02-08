<?php
/**
 * Template Part: Product Features
 *
 * Displays the product features/values section with quote and highlights.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values
$features_quote = hooan_get_field('features_quote');
$feature_highlights = hooan_get_field('feature_highlights');
?>

<section class="py-24 bg-secondary/10 dark:bg-primary/5">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <!-- Decorative Icon -->
        <span class="material-icons-outlined text-primary text-5xl mb-6">favorite_border</span>

        <!-- Quote -->
        <?php if ($features_quote) : ?>
            <h2 class="font-display text-3xl md:text-4xl font-semibold mb-8 italic">
                <?php echo esc_html($features_quote); ?>
            </h2>
        <?php endif; ?>

        <!-- Feature Highlights Grid -->
        <?php if (!empty($feature_highlights)) : ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <?php foreach ($feature_highlights as $highlight) : ?>
                    <div>
                        <div class="text-3xl font-display font-bold text-primary mb-1">
                            <?php echo esc_html($highlight['title']); ?>
                        </div>
                        <div class="text-sm uppercase tracking-widest font-bold opacity-60">
                            <?php echo esc_html($highlight['subtitle']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
