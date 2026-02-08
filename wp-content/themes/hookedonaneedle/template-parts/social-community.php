<?php
/**
 * Template Part: Social Community Section
 *
 * Displays the community TikTok CTA section with heading,
 * overlapping member avatars, community name, description,
 * and "Join on TikTok" button with branded hover effect.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values with defaults
$heading = function_exists('get_field') ? get_field('social_community_heading') : '';
$community_name = function_exists('get_field') ? get_field('social_community_name') : '';
$description = function_exists('get_field') ? get_field('social_community_description') : '';
$tiktok_url = function_exists('get_field') ? get_field('social_tiktok_url') : '';
$member_count = function_exists('get_field') ? get_field('social_member_count') : '';
$avatars = function_exists('get_field') ? get_field('social_member_avatars') : null;

// Default values
$heading = $heading ?: 'Join the Community';
$community_name = $community_name ?: 'The Stitch Squad';
$description = $description ?: 'Discover daily inspiration, viral tutorials, and behind-the-scenes magic with our vibrant creator community on TikTok.';
$tiktok_url = $tiktok_url ?: 'https://www.tiktok.com/@hookedonaneedle';
$member_count = $member_count ?: '+1.5k';

// Default avatars if none set
if (empty($avatars)) {
    $avatars = array(
        array('avatar' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBXDPts_5caOHEnuwEt3Zm0soP7uOZ1wGtXJ702YuCCVX0I1l_1fH-z0o6J4nOIsQ-5gPBxhPc6OcadfdjrWQBMtLNecQ4z_qrRBrRdmPXnQgVgWI7uDLtX9Pae3tgSYk24Z8nLVraNOOLxgBvRUNKCGVeLcADKJae1SCOzOJ2QTIvDquNmA_E_CukArCOSEz4PxpDK6v9KUUCgpbaS7hpefQMTdVFif0jbM1NF74V-3blP4FlRS6mhi2jYGu6JJ5nXqUP3vuxHLLI', 'alt' => 'Member')),
        array('avatar' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBFY5vllKkrNr4CVkJlUpNks--fWmFUt6SeOxEItAi94nNuwUWzf1UA1CEM9VQ2jfpYapfFOzGPNR26EKiupkHWwzY59uzVEGVvxM69PeJI3pxu6qt7bvJGQWNUeCwBTyvAbJa_1SxxCmLm5FyoKSEeB1U-b6cWOxqkIbpm4vuxOG0e7z3VznJ-ceIddhyjutx53ylJ0yMo6Chfl9DD7EGEatjE35WhacXsyNlceLmgtP42iiv0EcXIomcx-FvuFIVHSJEUEJcuEUw', 'alt' => 'Member')),
        array('avatar' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAUnazfnBg7fR7GHk0nvsHdFdWPTk1DE_Hdz0P1hN7RnOjdfE-r95FJ4jQ2pRvlgK9m_PjDht_f_b9NYccoOkjU9TZf_VuJdB8PK3cvE-5_-q8b12-Z_gdS8yTmBM3FRVGT315gV_KRB-sJmhdSf-0ViRF3_zaj9UP757cw1zuYQ7JUEzhXWgzPV2rlb1FroSMpLg890cII01cGbbZPTaxSFbTnmDPoAsNkLOhOKm59UFkQVWzKMrq2LWR96ue7N17yRGIduLBoXRE', 'alt' => 'Member')),
    );
}
?>

<div class="flex flex-col h-full">
    <!-- Section Header -->
    <div class="flex items-center gap-3 mb-6">
        <span class="material-icons-outlined text-primary">groups</span>
        <h2 class="text-3xl font-display"><?php echo esc_html($heading); ?></h2>
    </div>

    <!-- Community Card -->
    <div class="flex-grow bg-[#F1F5F9] dark:bg-accent-dark/50 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 flex flex-col justify-center items-center text-center space-y-6">
        <!-- Overlapping Avatars -->
        <?php if (!empty($avatars)) : ?>
            <div class="flex -space-x-3">
                <?php foreach ($avatars as $avatar_item) :
                    $avatar = isset($avatar_item['avatar']) ? $avatar_item['avatar'] : null;
                    if ($avatar && !empty($avatar['url'])) :
                        $avatar_url = $avatar['url'];
                        $avatar_alt = !empty($avatar['alt']) ? $avatar['alt'] : 'Member';
                ?>
                    <img
                        src="<?php echo esc_url($avatar_url); ?>"
                        alt="<?php echo esc_attr($avatar_alt); ?>"
                        class="w-12 h-12 rounded-full border-2 border-white object-cover"
                    />
                <?php
                    endif;
                endforeach;
                ?>
                <!-- Member Count Badge -->
                <div class="w-12 h-12 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                    <?php echo esc_html($member_count); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Community Info -->
        <div>
            <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($community_name); ?></h3>
            <p class="text-slate-500 max-w-sm mx-auto"><?php echo esc_html($description); ?></p>
        </div>

        <!-- TikTok CTA Button -->
        <a
            href="<?php echo esc_url($tiktok_url); ?>"
            class="group relative inline-flex items-center gap-2 bg-black dark:bg-slate-900 text-white px-8 py-3 rounded-full font-medium transition-all hover:shadow-[4px_4px_0px_0px_rgba(105,201,208,0.8),-4px_-4px_0px_0px_rgba(238,29,82,0.8)] overflow-hidden"
            target="_blank"
            rel="noopener noreferrer"
        >
            <!-- TikTok Icon -->
            <svg class="w-5 h-5 fill-current relative z-10" viewBox="0 0 24 24">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.17-2.89-.6-4.09-1.47-1.26-.93-2.15-2.32-2.52-3.83-.02 1.61-.01 3.23-.01 4.85-.01 2.91.01 5.82-.02 8.73-.03 1.05-.18 2.13-.59 3.12-.48 1.18-1.29 2.22-2.33 2.94-1.29.9-2.89 1.35-4.47 1.25-1.39-.08-2.77-.58-3.87-1.46-1.17-.93-1.95-2.29-2.16-3.76-.23-1.5-.02-3.08.62-4.46.68-1.43 1.9-2.61 3.39-3.21 1.25-.51 2.63-.64 3.95-.39v4.11c-.74-.2-1.54-.18-2.25.08-.7.25-1.3.74-1.68 1.37-.42.66-.56 1.48-.4 2.24.16.76.6 1.45 1.24 1.89.65.46 1.47.64 2.25.53.79-.11 1.51-.53 1.99-1.18.38-.52.56-1.18.57-1.83.02-3.88.01-7.77.02-11.66z"></path>
            </svg>
            <span class="relative z-10">Join on TikTok</span>
        </a>
    </div>
</div>
