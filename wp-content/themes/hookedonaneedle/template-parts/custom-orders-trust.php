<?php
/**
 * Template Part: Custom Orders Trust Bar
 *
 * Displays turnaround time, fiber quality, and handmade trust signals.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$trust_items = get_field('co_trust_items');
if (empty($trust_items)) {
    $trust_items = array(
        array('value' => '4 – 6 wks',       'label' => 'Typical Turnaround'),
        array('value' => 'Premium Fibers',   'label' => 'Natural & Artisan Yarns'),
        array('value' => 'Handmade',         'label' => 'Every Stitch, Every Time'),
    );
}
?>

<section class="custom-orders-trust">
    <div class="custom-orders-trust__grid">
        <?php foreach ($trust_items as $item) : ?>
            <div class="custom-orders-trust__col">
                <p class="custom-orders-trust__value font-display"><?php echo esc_html($item['value']); ?></p>
                <p class="custom-orders-trust__label"><?php echo esc_html($item['label']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
