<?php
/**
 * Template Part: Social Live CTA Section
 *
 * Displays the hero-like Live CTA section with TikTok live indicator,
 * preview image or TikTok embed, headline, description, and CTA buttons.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values with defaults
$headline_main = function_exists('get_field') ? get_field('social_headline_main') : '';
$headline_emphasis = function_exists('get_field') ? get_field('social_headline_emphasis') : '';
$headline_secondary = function_exists('get_field') ? get_field('social_headline_secondary') : '';
$description = function_exists('get_field') ? get_field('social_description') : '';
$preview_image = function_exists('get_field') ? get_field('social_preview_image') : null;
$tiktok_video_url = function_exists('get_field') ? get_field('social_tiktok_video_url') : '';
$primary_cta_label = function_exists('get_field') ? get_field('social_primary_cta_label') : '';
$primary_cta_url = function_exists('get_field') ? get_field('social_primary_cta_url') : '';
$secondary_cta_label = function_exists('get_field') ? get_field('social_secondary_cta_label') : '';
$secondary_cta_url = function_exists('get_field') ? get_field('social_secondary_cta_url') : '';
$tiktok_handle = function_exists('get_field') ? get_field('social_tiktok_handle') : '';
$viewer_count = function_exists('get_field') ? get_field('social_viewer_count') : '';

// Default values
$headline_main = $headline_main ?: 'Stitching';
$headline_emphasis = $headline_emphasis ?: 'Live with';
$headline_secondary = $headline_secondary ?: 'Community.';
$description = $description ?: "Join our daily creative session! We're currently working on the 'Sand & Sea' shawl pattern. Ask questions, learn new stitches, or just relax with us.";
$primary_cta_label = $primary_cta_label ?: 'Join Live Now';
$primary_cta_url = $primary_cta_url ?: '#';
$secondary_cta_label = $secondary_cta_label ?: 'View All Replays';
$secondary_cta_url = $secondary_cta_url ?: '#';
$tiktok_handle = $tiktok_handle ?: '@hookedonaneedle';
$viewer_count = $viewer_count ?: '1.2k watching';

// Default preview image
$default_preview_image = 'https://lh3.googleusercontent.com/aida-public/AB6AXuA_W84n19mRzNgVhcyjK7Xbigt0IvK66-J6oSU5dJKV9ERo-mvxZl7xPkuu7s7a5m2mHIuLny94gkImdKKeOEpLI2N-P7nN4cbHVc1gqQsq-O7PqEMdvv00b2HdJhX6NmucirqC_ookr98PbZfRoA6b3q7BibPIbF_qmojC3Zadie3Zy470SL_qsFFkbJecUWIaaFvYZFNDTnrJnxbbuakMzVsJA6XRkXrz2Pg-IIELYq23Xrt-MWS3Md84hTixKTJP2OI4zib00t0';

// Get image URL with fallback
if ($preview_image && is_array($preview_image) && !empty($preview_image['url'])) {
    $preview_image_url = $preview_image['url'];
    $preview_image_alt = !empty($preview_image['alt']) ? $preview_image['alt'] : 'TikTok Live Preview';
} else {
    $preview_image_url = $default_preview_image;
    $preview_image_alt = 'TikTok Live Preview';
}

// Extract TikTok video ID from URL if provided
$tiktok_video_id = '';
if (!empty($tiktok_video_url)) {
    // Pattern matches URLs like https://www.tiktok.com/@user/video/1234567890
    if (preg_match('/video\/(\d+)/', $tiktok_video_url, $matches)) {
        $tiktok_video_id = $matches[1];
    }
}

$has_tiktok_embed = !empty($tiktok_video_id);
?>

<section class="mb-20">
    <!-- Live Indicator -->
    <div class="flex items-center gap-2 mb-6">
        <span class="flex h-2 w-2 rounded-full bg-red-500">
            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75"></span>
        </span>
        <span class="text-red-500 font-semibold tracking-widest text-xs uppercase">Live on TikTok</span>
    </div>

    <!-- Main Card -->
    <div class="grid lg:grid-cols-12 gap-12 items-center bg-white dark:bg-accent-dark p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800">
        <!-- Media Column (7 cols on lg) -->
        <div class="lg:col-span-7">
            <div class="aspect-[9/16] md:aspect-video w-full bg-slate-100 dark:bg-slate-900 rounded-2xl overflow-hidden relative group">
                <?php if ($has_tiktok_embed) : ?>
                    <!-- TikTok Embed -->
                    <blockquote
                        class="tiktok-embed w-full h-full"
                        cite="<?php echo esc_url($tiktok_video_url); ?>"
                        data-video-id="<?php echo esc_attr($tiktok_video_id); ?>"
                        style="max-width: 100%; min-width: 100%;"
                    >
                        <section></section>
                    </blockquote>
                <?php else : ?>
                    <!-- Preview Image Fallback -->
                    <img
                        src="<?php echo esc_url($preview_image_url); ?>"
                        alt="<?php echo esc_attr($preview_image_alt); ?>"
                        class="w-full h-full object-cover"
                    />

                    <!-- Play Button Overlay -->
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                        <div class="bg-white/20 backdrop-blur-sm p-4 rounded-full">
                            <span class="material-icons-outlined text-6xl text-white">play_arrow</span>
                        </div>
                    </div>

                    <!-- Live Badge -->
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-md text-xs font-bold uppercase flex items-center gap-1">
                        <span class="material-icons-outlined text-xs">sensors</span> Live
                    </div>
                <?php endif; ?>

                <!-- TikTok Channel Info Overlay -->
                <div class="absolute bottom-4 left-4 flex items-center gap-3 bg-black/40 backdrop-blur-md p-3 rounded-xl border border-white/10">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">H</div>
                    <div>
                        <p class="text-white text-sm font-semibold"><?php echo esc_html($tiktok_handle); ?></p>
                        <p class="text-white/70 text-xs"><?php echo esc_html($viewer_count); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Column (5 cols on lg) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Three-Part Headline -->
            <h1 class="text-5xl md:text-6xl font-display leading-[1.1]">
                <?php echo esc_html($headline_main); ?> <br/>
                <span class="italic text-primary"><?php echo esc_html($headline_emphasis); ?></span> <br/>
                <?php echo esc_html($headline_secondary); ?>
            </h1>

            <!-- Description -->
            <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
                <?php echo esc_html($description); ?>
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <a
                    href="<?php echo esc_url($primary_cta_url); ?>"
                    class="bg-primary text-white px-8 py-4 rounded-full font-medium flex items-center justify-center gap-2 hover:opacity-90 transition-all"
                >
                    <?php echo esc_html($primary_cta_label); ?>
                </a>
                <a
                    href="<?php echo esc_url($secondary_cta_url); ?>"
                    class="border border-slate-200 dark:border-slate-700 px-8 py-4 rounded-full font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-center"
                >
                    <?php echo esc_html($secondary_cta_label); ?>
                </a>
            </div>
        </div>
    </div>
</section>
