<?php
/**
 * The footer template
 *
 * Displays the site footer with navigation links and social media.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get footer content from ACF
$footer_description = hooan_get_field('footer_description');
$social_links = hooan_get_field('social_links');
$explore_links = hooan_get_field('explore_links');
$support_links = hooan_get_field('support_links');
$copyright_text = hooan_get_field('copyright_text');
?>

<?php do_action('hooan_before_footer'); ?>

<footer class="bg-slate-900 text-slate-400 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-white font-display text-2xl font-bold mb-6">HOOKED ON A NEEDLE</h3>
                <p class="max-w-xs leading-relaxed">
                    <?php echo esc_html($footer_description); ?>
                </p>

                <!-- Social Links -->
                <?php if (!empty($social_links)) : ?>
                    <div class="flex gap-4 mt-6">
                        <?php foreach ($social_links as $link) :
                            $icon = hooan_get_social_icon($link['icon']);
                        ?>
                            <a
                                href="<?php echo esc_url($link['url']); ?>"
                                class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary transition-colors"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="<?php echo esc_attr(ucfirst($link['icon'])); ?>"
                            >
                                <span class="material-icons-outlined"><?php echo esc_html($icon); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Explore Links Column -->
            <div>
                <h4 class="text-white font-bold mb-6"><?php _e('Explore', 'hookedonaneedle'); ?></h4>
                <?php if (!empty($explore_links)) : ?>
                    <ul class="space-y-4">
                        <?php foreach ($explore_links as $link) : ?>
                            <li>
                                <a href="<?php echo esc_url($link['url']); ?>" class="hover:text-white transition-colors">
                                    <?php echo esc_html($link['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Support Links Column -->
            <div>
                <h4 class="text-white font-bold mb-6"><?php _e('Support', 'hookedonaneedle'); ?></h4>
                <?php if (!empty($support_links)) : ?>
                    <ul class="space-y-4">
                        <?php foreach ($support_links as $link) : ?>
                            <li>
                                <a href="<?php echo esc_url($link['url']); ?>" class="hover:text-white transition-colors">
                                    <?php echo esc_html($link['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-12 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <p><?php echo esc_html($copyright_text); ?></p>
            <div class="flex items-center gap-2">
                <span class="material-icons-outlined text-primary">bookmark</span>
                <span class="font-medium"><?php _e('Bookmark Us & Stay Tuned', 'hookedonaneedle'); ?></span>
            </div>
        </div>
    </div>
</footer>

<?php get_template_part('template-parts/waitlist-modal'); ?>

<?php wp_footer(); ?>
</body>
</html>
