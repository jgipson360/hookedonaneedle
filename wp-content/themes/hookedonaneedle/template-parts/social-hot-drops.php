<?php
/**
 * Template Part: Social Hot Drops Section
 *
 * Displays the Hot Drops grid section with heading, follow link,
 * and a 2-column grid of product/content items with hover effects.
 * The last item shows a "Shop Now" overlay on hover.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values with defaults
$heading = function_exists('get_field') ? get_field('social_hotdrops_heading') : '';
$follow_text = function_exists('get_field') ? get_field('social_hotdrops_follow_text') : '';
$follow_url = function_exists('get_field') ? get_field('social_hotdrops_follow_url') : '';
$items = function_exists('get_field') ? get_field('social_hotdrops_items') : null;

// Default values
$heading = $heading ?: 'Hot Drops';
$follow_text = $follow_text ?: 'Follow @hookedonaneedle';
$follow_url = $follow_url ?: '#';

// Default items if none set
if (empty($items)) {
    $items = array(
        array(
            'image' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdCePE5EL5sBJa3cnifBjo4TzJ-o8059LGeT0Wg7yJj_YxTn1TH4jRnf5TYFZlZBRiO6gTpTFPDp7wyz3JjcBit2J-9_q5w-T_49zOfbVuIRIaij_QWK_eKrnsixiVUOkxGaAkvQnWaO8WtrLOmBOckfQzXoB-HZhlwG2eeSosBG4qVJvWD5LSh5P_jT8GMDc1oQJsja1ujJSh4kAcZItIAJvxHrTFwwW9nv6QKClVwBJsSX3GTDVFc5Kunu4OBsEeGMB--JHPSmQ'),
            'alt_text' => 'Hot Drop Item',
            'link_url' => '',
        ),
        array(
            'image' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAiaAxt7HBv1u5LuEL0GymuOoqZWs3VX1VmddsV7j1vr3RvH3h4AR0In1hUlF8SSISrAbr2BLBwOCBvFpEW4ONVe_vI5QY7cdvEqBmlebueoC6nMMWyi2irhubir2u6glaPfN802D31amF8n9Hlw-8rCCLj_ZKCMkMPl7dP1cCwRW6F7NGqsQB4oQ3UmwX0X71M8knjCwGA_hYKBt_1Xn2YMfCstbgJaHAC9M4S2Gz_QyzpiWBDx5KLp7O8T-0GjMmeDxJvvvqz6t0'),
            'alt_text' => 'Hot Drop Item',
            'link_url' => '',
        ),
        array(
            'image' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_oc-pIfyVZkY6Rgw4UHikvuPA7OPaWIXILZVHCzZGbSrXUb-8eYzyKleWFeJ3d3InBoBknw4U0ygtDehRECTBnTpiEzJdLPUgTeTo2bqASGoexrlZcelHo6U2vljgVW07u804eSXS_SLXmmnoYTLiNlpcg9N_l-efwOsrm6C3MzFEtp59Fqw-oS2JmKl3wVWx9f9pEZFVSm5Jc8aJ95cV5X91YF0W-o-EHoFctUtSeuxAXPOZ6MIFJsyDPfaEcJIIwQPAgrIRD3o'),
            'alt_text' => 'Hot Drop Item',
            'link_url' => '',
        ),
        array(
            'image' => array('url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBiE-etzd_oAGKEn5a4HOT1z5s4OP4i-IKZmr1WLQldPkNZ_6lL2wh1DFbwrq7Pa4pSMgO3edSd78pQ6WPOu3sX-LphQjCgpDwNRBfaLPW9Djm_KMAcKgxrUi08MLkpuOeXRhIeMmz9d9RgH9bBUQvhr9fO4M-a3PWMpVa99NBX6ll0BxDZQAliaGtWFzB98ab84tF41vHiptrhOz5W1IHjkAid4S9IYAjYibvk73e7i8xg-wHkKAYWQVx5eU22hYuAHWGcatvQc_U'),
            'alt_text' => 'Hot Drop Item',
            'link_url' => '#',
        ),
    );
}

$total_items = count($items);
?>

<div>
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <span class="material-icons-outlined text-primary">local_fire_department</span>
            <h2 class="text-3xl font-display"><?php echo esc_html($heading); ?></h2>
        </div>
        <?php if ($follow_text && $follow_url) : ?>
            <a
                href="<?php echo esc_url($follow_url); ?>"
                class="text-sm font-medium text-slate-500 hover:text-primary transition-colors flex items-center gap-1"
            >
                <?php echo esc_html($follow_text); ?>
                <span class="material-icons-outlined text-xs">arrow_forward</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Items Grid -->
    <?php if (!empty($items)) : ?>
        <div class="grid grid-cols-2 gap-4">
            <?php
            $index = 0;
            foreach ($items as $item) :
                $index++;
                $image = isset($item['image']) ? $item['image'] : null;
                $alt_text = isset($item['alt_text']) ? $item['alt_text'] : 'Hot Drop Item';
                $link_url = isset($item['link_url']) ? $item['link_url'] : '';
                $is_last = ($index === $total_items);

                // Get image URL
                $image_url = '';
                if ($image && is_array($image) && !empty($image['url'])) {
                    $image_url = $image['url'];
                }

                if (empty($image_url)) {
                    continue;
                }
            ?>
                <div class="aspect-square rounded-2xl bg-slate-200 overflow-hidden group relative">
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt="<?php echo esc_attr($alt_text); ?>"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    />

                    <?php if ($is_last) : ?>
                        <!-- Shop Now Overlay (last item only) -->
                        <div class="absolute inset-0 bg-primary/40 backdrop-blur-[2px] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <?php if ($link_url) : ?>
                                <a
                                    href="<?php echo esc_url($link_url); ?>"
                                    class="text-white font-medium px-4 py-2 border border-white rounded-full hover:bg-white hover:text-primary transition-colors"
                                >
                                    Shop Now
                                </a>
                            <?php else : ?>
                                <span class="text-white font-medium px-4 py-2 border border-white rounded-full">Shop Now</span>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($link_url) : ?>
                        <!-- Clickable link for non-last items -->
                        <a href="<?php echo esc_url($link_url); ?>" class="absolute inset-0 z-10" aria-label="<?php echo esc_attr($alt_text); ?>"></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
