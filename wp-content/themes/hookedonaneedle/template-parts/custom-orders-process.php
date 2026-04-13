<?php
/**
 * Template Part: Custom Orders Process Strip
 *
 * Displays the 5-step commission process (Inquire, Consult, Confirm, Create, Deliver).
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$steps = get_field('co_process_steps');
if (empty($steps)) {
    $steps = array(
        array('num' => '01', 'title' => 'Inquire',  'desc' => 'Share your vision with us'),
        array('num' => '02', 'title' => 'Consult',  'desc' => 'We refine the details together'),
        array('num' => '03', 'title' => 'Confirm',  'desc' => 'Quote, deposit, timeline'),
        array('num' => '04', 'title' => 'Create',   'desc' => 'Handcrafted with care'),
        array('num' => '05', 'title' => 'Deliver',  'desc' => 'Shipped to your door'),
    );
}
?>

<section class="custom-orders-process">
    <div class="custom-orders-process__grid">
        <?php foreach ($steps as $i => $step) : ?>
            <div class="custom-orders-process__col<?php echo $i < count($steps) - 1 ? ' custom-orders-process__col--bordered' : ''; ?>">
                <p class="custom-orders-process__num font-display"><?php echo esc_html($step['num']); ?></p>
                <p class="custom-orders-process__title"><?php echo esc_html($step['title']); ?></p>
                <p class="custom-orders-process__desc"><?php echo esc_html($step['desc']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
