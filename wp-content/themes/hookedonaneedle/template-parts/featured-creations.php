<?php
/**
 * Template Part: Featured Creations
 *
 * Displays the featured creations grid section.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values
$section_title = hooan_get_field('featured_section_title');
$section_subtitle = hooan_get_field('featured_section_subtitle');
$lookbook_link = hooan_get_field('featured_lookbook_link');
$featured_creations = hooan_get_field('featured_creations');

// Default images from mock
$default_images = array(
    'https://lh3.googleusercontent.com/aida-public/AB6AXuAyqY547zRsNoKoUL2wZ-NZz-zYLKgSRG4_nHlbRqKi-jlzDFfTaEDEBin1EXD9S1aSJgbX2Zfjtc63IJcwd6OrcjkMnA11LP2dXQlW36LnwB9r1QYd8VYTiGCSKRtF7yKudeMNQBx_BeWuV5Ib-Oc7z_M410o-od4IR81fPVZ7KsZtah7WxsWICIDrRGqN9i6nlFoxIIv7Wk9cwpA7uDTO2aOSn8ZWSvnarZI-d1AQ4cZfTWOP4Zj3_D_m8dEjbqxA8FyoUCWyQLQ',
    'https://lh3.googleusercontent.com/aida-public/AB6AXuCbqML0H8Vm8NWhmMPajYog7kJFi9tSr7nydGF1C_FjUGT8Kr1OCJ5_7XIhrtPbga3y8fusN28HkVfIl6_O6XQNYLjosY50ICjC88dx0uKPaxYF0840-I2a-wyNChW9fIk71xpuifA_J9KFZ5vym-sfG0YjKOoftET5Vr5B6mqWqtaL2O5Rzjevj690aaCo5RE3oX7-AZAqUl7wEiYXqHvFgROCzL4ux3bPtTvE9D-uwQ9vqDoWzFXCMJOcHMuPK3jozYA8niYpge4',
    'https://lh3.googleusercontent.com/aida-public/AB6AXuCaVkzk4tNKM19xLIgNlPVvR0HLpPouHoaPrE0GggExUxR1q_UZU2i8YShaUXKrYRLRT-ktl60LYkyNqeg3wwDd4ShK3mCnGsNnc_iHhylite0cfXLTOursZEpUa_Vda8PoIX5svGL3Yj9rCpaA8K9AwUHLn8c1w1qSbJ4DNC_GViwKh4YLNQLru9D9ag2U5kJsET6HB_Z1FtqOWPhlOV2fMLwBdfVZ3H6Z4j5i3BRdgUHxe5ST_enneQ5lxzFFjXkDVypzhkqJEvA',
);
?>

<section class="py-24 bg-white dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div>
                <h2 class="font-display text-4xl md:text-5xl font-semibold mb-4">
                    <?php echo esc_html($section_title); ?>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    <?php echo esc_html($section_subtitle); ?>
                </p>
            </div>
            <?php if ($lookbook_link) : ?>
                <a href="<?php echo esc_url($lookbook_link); ?>" class="group flex items-center gap-2 text-primary font-bold">
                    <?php _e('View Lookbook', 'hookedonaneedle'); ?>
                    <span class="material-icons-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Featured Creations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if (!empty($featured_creations)) : ?>
                <?php foreach ($featured_creations as $index => $creation) :
                    // Get image URL (use default if not set)
                    $image_url = isset($creation['image']['url']) ? $creation['image']['url'] : (isset($default_images[$index]) ? $default_images[$index] : '');
                    $image_alt = isset($creation['image']['alt']) ? $creation['image']['alt'] : $creation['title'];
                ?>
                    <div class="group cursor-pointer featured-creation-card">
                        <!-- Image Container -->
                        <div class="relative aspect-[4/5] rounded-2xl overflow-hidden mb-6">
                            <img
                                src="<?php echo esc_url($image_url); ?>"
                                alt="<?php echo esc_attr($image_alt); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <!-- Text Content -->
                        <h3 class="font-display text-2xl font-semibold mb-2">
                            <?php echo esc_html($creation['title']); ?>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            <?php echo esc_html($creation['description']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
