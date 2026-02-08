<?php
/**
 * Template Part: Email Form
 *
 * Displays the waitlist email capture form with validation.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */
?>

<form id="waitlist-form" class="waitlist-form flex flex-col sm:flex-row gap-3 max-w-md" method="post">
    <input
        type="email"
        name="email"
        class="flex-1 px-6 py-4 rounded-full border-2 border-pink-100 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 focus:border-primary focus:ring-0 transition-all outline-none"
        placeholder="<?php esc_attr_e('Enter your email', 'hookedonaneedle'); ?>"
        required
        aria-label="<?php esc_attr_e('Email address', 'hookedonaneedle'); ?>"
    />
    <button
        type="submit"
        class="bg-primary text-white px-8 py-4 rounded-full font-bold hover:shadow-lg hover:shadow-primary/20 transition-all"
    >
        <?php _e('Notify Me', 'hookedonaneedle'); ?>
    </button>
</form>

<!-- Form Message Container -->
<div class="form-message hidden max-w-md"></div>
