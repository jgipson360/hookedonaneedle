<?php
/**
 * Template Part: Waitlist Modal
 *
 * Full-screen modal with name + email form for joining the waitlist.
 * Triggered by "Join Waitlist" buttons in the header/nav.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */
?>

<div id="waitlist-modal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true" aria-labelledby="waitlist-modal-title">
    <!-- Backdrop -->
    <div id="waitlist-modal-backdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Panel -->
    <div class="flex items-center justify-center min-h-full p-4">
        <div class="relative bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md p-8 z-10">
            <!-- Close Button -->
            <button
                id="waitlist-modal-close"
                class="absolute top-4 right-4 p-1 rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 transition-colors"
                aria-label="<?php esc_attr_e('Close', 'hookedonaneedle'); ?>"
            >
                <span class="material-icons-outlined">close</span>
            </button>

            <!-- Header -->
            <div class="text-center mb-8">
                <span class="material-icons-outlined text-primary text-4xl mb-3 block">favorite</span>
                <h2 id="waitlist-modal-title" class="font-display text-2xl font-bold text-slate-900 dark:text-white">
                    <?php _e('Join the Waitlist', 'hookedonaneedle'); ?>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">
                    <?php _e('Be the first to know when we launch new drops and collections.', 'hookedonaneedle'); ?>
                </p>
            </div>

            <!-- Form -->
            <form id="waitlist-modal-form" class="waitlist-form flex flex-col gap-4" method="post">
                <div>
                    <label for="waitlist-name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        <?php _e('Name', 'hookedonaneedle'); ?>
                    </label>
                    <input
                        type="text"
                        id="waitlist-name"
                        name="name"
                        class="w-full px-5 py-3 rounded-xl border-2 border-pink-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 focus:border-primary focus:ring-0 transition-all outline-none"
                        placeholder="<?php esc_attr_e('Your name', 'hookedonaneedle'); ?>"
                        required
                        aria-label="<?php esc_attr_e('Your name', 'hookedonaneedle'); ?>"
                    />
                </div>
                <div>
                    <label for="waitlist-email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        <?php _e('Email', 'hookedonaneedle'); ?>
                    </label>
                    <input
                        type="email"
                        id="waitlist-email"
                        name="email"
                        class="w-full px-5 py-3 rounded-xl border-2 border-pink-100 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 focus:border-primary focus:ring-0 transition-all outline-none"
                        placeholder="<?php esc_attr_e('you@example.com', 'hookedonaneedle'); ?>"
                        required
                        aria-label="<?php esc_attr_e('Email address', 'hookedonaneedle'); ?>"
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-primary text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all mt-2"
                >
                    <?php _e('Notify Me', 'hookedonaneedle'); ?>
                </button>
            </form>

            <!-- Form Message Container -->
            <div class="form-message hidden max-w-md mt-3"></div>

            <p class="text-center text-xs text-slate-400 dark:text-slate-500 mt-4">
                <?php _e('No spam, ever. Unsubscribe anytime.', 'hookedonaneedle'); ?>
            </p>
        </div>
    </div>
</div>
