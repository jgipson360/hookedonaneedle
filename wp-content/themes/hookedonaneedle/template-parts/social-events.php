<?php
/**
 * Template Part: Social Events Section
 *
 * Displays the upcoming events section with editable title, subtitle,
 * and a repeater of event items with date, title, description, time,
 * and "Add to Calendar" button.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

// Get ACF field values with defaults
$section_title = function_exists('get_field') ? get_field('social_events_title') : '';
$section_subtitle = function_exists('get_field') ? get_field('social_events_subtitle') : '';
$events = function_exists('get_field') ? get_field('social_events') : null;

// Default values
$section_title = $section_title ?: 'Upcoming Events';
$section_subtitle = $section_subtitle ?: 'Join our scheduled crochet-alongs and masterclasses';

// Default events if none set
if (empty($events)) {
    $events = array(
        array(
            'event_date' => '20241024',
            'event_title' => 'Heirloom Blanket CAL',
            'event_description' => 'A 4-part series on complex texture stitching.',
            'event_time' => '6:00 PM EST',
        ),
        array(
            'event_date' => '20241027',
            'event_title' => 'Sustainable Fashion Q&A',
            'event_description' => 'Discussion on sourcing organic cotton & wool.',
            'event_time' => '2:00 PM EST',
        ),
        array(
            'event_date' => '20241102',
            'event_title' => 'Winter Collection Drop',
            'event_description' => 'Live reveal of our newest winter accessories.',
            'event_time' => '12:00 PM EST',
        ),
    );
}
?>

<section class="mb-20">
    <!-- Section Header -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-display mb-2"><?php echo esc_html($section_title); ?></h2>
        <p class="text-slate-500"><?php echo esc_html($section_subtitle); ?></p>
    </div>

    <!-- Events List -->
    <?php if (!empty($events)) : ?>
        <div class="grid gap-4">
            <?php foreach ($events as $event) :
                // Parse date from ACF date picker format (Ymd)
                $event_date = isset($event['event_date']) ? $event['event_date'] : '';
                $event_title = isset($event['event_title']) ? $event['event_title'] : '';
                $event_description = isset($event['event_description']) ? $event['event_description'] : '';
                $event_time = isset($event['event_time']) ? $event['event_time'] : '';

                // Format date for display
                $day = '';
                $month = '';
                if (!empty($event_date)) {
                    $timestamp = strtotime($event_date);
                    if ($timestamp !== false) {
                        $day = date('d', $timestamp);
                        $month = date('M', $timestamp);
                    }
                }
            ?>
                <div class="group flex flex-col md:flex-row items-center justify-between p-6 bg-white dark:bg-accent-dark rounded-2xl border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all">
                    <!-- Left: Date + Event Info -->
                    <div class="flex items-center gap-6 mb-4 md:mb-0">
                        <!-- Date Badge -->
                        <?php if ($day && $month) : ?>
                            <div class="text-center w-16">
                                <span class="block text-2xl font-display font-bold text-primary"><?php echo esc_html($day); ?></span>
                                <span class="text-xs uppercase tracking-widest text-slate-400"><?php echo esc_html($month); ?></span>
                            </div>
                            <!-- Vertical Divider -->
                            <div class="h-12 w-px bg-slate-100 dark:bg-slate-700 hidden md:block"></div>
                        <?php endif; ?>

                        <!-- Event Details -->
                        <div>
                            <?php if ($event_title) : ?>
                                <h3 class="text-xl font-display font-semibold"><?php echo esc_html($event_title); ?></h3>
                            <?php endif; ?>
                            <?php if ($event_description) : ?>
                                <p class="text-sm text-slate-500"><?php echo esc_html($event_description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right: Time + CTA -->
                    <div class="flex items-center gap-4">
                        <?php if ($event_time) : ?>
                            <span class="text-sm text-slate-500"><?php echo esc_html($event_time); ?></span>
                        <?php endif; ?>
                        <button class="px-6 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-all text-sm font-medium">
                            Add to Calendar
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
