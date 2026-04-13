<?php
/**
 * Product Details Section
 *
 * Displays ACF crochet-specific fields on the single product page.
 *
 * @package HookedOnANeedle
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('get_field')) {
    return;
}

global $product;
$product_id = $product ? $product->get_id() : get_the_ID();

$fiber_yarn = get_field('fiber_yarn_type', $product_id);
$care = get_field('care_instructions', $product_id);
$difficulty = get_field('difficulty_level', $product_id);

if (!$fiber_yarn && !$care && !$difficulty) {
    return;
}
?>

<div class="border-t border-pink-100 dark:border-slate-700 pt-4 mt-4">
    <h3 class="font-display text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">Product Details</h3>
    <dl class="space-y-3 font-sans text-sm">
        <?php if ($fiber_yarn) : ?>
            <div class="flex gap-2">
                <dt class="text-slate-500 dark:text-slate-400 w-32 flex-shrink-0">Fiber / Yarn</dt>
                <dd class="text-slate-700 dark:text-slate-300"><?php echo esc_html($fiber_yarn); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ($care) : ?>
            <div class="flex gap-2">
                <dt class="text-slate-500 dark:text-slate-400 w-32 flex-shrink-0">Care</dt>
                <dd class="text-slate-700 dark:text-slate-300"><?php echo nl2br(esc_html($care)); ?></dd>
            </div>
        <?php endif; ?>
        <?php if ($difficulty) : ?>
            <div class="flex gap-2">
                <dt class="text-slate-500 dark:text-slate-400 w-32 flex-shrink-0">Difficulty</dt>
                <dd class="text-slate-700 dark:text-slate-300"><?php echo esc_html($difficulty); ?></dd>
            </div>
        <?php endif; ?>
    </dl>
</div>
