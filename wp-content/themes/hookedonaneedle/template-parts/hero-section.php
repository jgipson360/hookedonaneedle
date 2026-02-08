<?php
/**
 * Template Part: Hero Section
 *
 * Displays the hero section with announcement badge, headline,
 * subtitle, email capture form, and featured image.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values with defaults
$announcement_badge = hooan_get_field('announcement_badge');
$headline_main = hooan_get_field('headline_main');
$headline_emphasis = hooan_get_field('headline_emphasis');
$headline_secondary = hooan_get_field('headline_secondary');
$subtitle = hooan_get_field('subtitle');
$hero_image = function_exists('get_field') ? get_field('hero_image') : null;

// Debug: uncomment to see what's being returned
echo '<!-- Hero Image Debug: ' . print_r($hero_image, true) . ' -->';

// Default hero image URLs (from mock)
$default_hero_image = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDHtmlbxMqncmOegPf_TlYkJTDv9msvc5_qxisJp2jiLWm9qZ9NBAwSm2NiSh6Cmh9FLdGcKXISjdzjOinrXW6k_kKeWBDmgxYjE60WsAVXROEoxYfOTRdxW-ebzFWjXIg7WQ51Aza8pI6rIK8GqcD5V23NYienfnEUSmKDaL9_WHmwxsN79kg_d8vi3Ff-pNRL4JayzcHlMWp6C6YBHNvNm3AmTmyzMBAih4PdbWfm6XJ31rj3C3Ghxev9YTkDHQh5eCmFwzO8gy8';

// Get image URL with proper fallback
if ($hero_image && is_array($hero_image) && !empty($hero_image['url'])) {
    $hero_image_url = $hero_image['url'];
    $hero_image_alt = !empty($hero_image['alt']) ? $hero_image['alt'] : 'Detailed crochet work';
} else {
    $hero_image_url = $default_hero_image;
    $hero_image_alt = 'Detailed crochet work';
}
?>

<?php do_action('hooan_before_hero'); ?>

<header class="relative min-h-screen flex items-center pt-20 crochet-bg overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <!-- Left Content -->
        <div class="z-10 space-y-8 animate-fade-in">
            <!-- Announcement Badge -->
            <?php if ($announcement_badge) : ?>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-pink-100 dark:bg-pink-900/30 text-primary font-semibold text-sm">
                    <span class="material-icons-outlined text-sm">auto_awesome</span>
                    <?php echo esc_html($announcement_badge); ?>
                </div>
            <?php endif; ?>

            <!-- Main Headline -->
            <h1 class="font-display text-5xl md:text-7xl leading-tight font-semibold text-slate-900 dark:text-white">
                <?php echo esc_html($headline_main); ?> <br/>
                <span class="text-primary italic"><?php echo esc_html($headline_emphasis); ?></span> <br/>
                <?php echo esc_html($headline_secondary); ?>
            </h1>

            <!-- Subtitle -->
            <?php if ($subtitle) : ?>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-lg leading-relaxed">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <!-- Email Capture Form -->
            <?php get_template_part('template-parts/email-form'); ?>
        </div>

        <!-- Right Side - Hero Image -->
        <div class="relative">
            <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl md:rotate-2 hover:rotate-0 transition-transform duration-500">
                <img
                    src="<?php echo esc_url($hero_image_url); ?>"
                    alt="<?php echo esc_attr($hero_image_alt); ?>"
                    class="w-full h-[400px] md:h-[600px] object-cover"
                    fetchpriority="high"
                    decoding="async"
                />
            </div>
            <!-- Decorative Blur Elements -->
            <div class="absolute -bottom-6 -left-6 w-64 h-64 bg-secondary/30 rounded-full blur-3xl -z-10"></div>
            <div class="absolute -top-6 -right-6 w-64 h-64 bg-primary/10 rounded-full blur-3xl -z-10"></div>
        </div>
    </div>
</header>

<?php do_action('hooan_after_hero'); ?>
