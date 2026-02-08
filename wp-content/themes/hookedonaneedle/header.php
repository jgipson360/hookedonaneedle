<?php
/**
 * The header template
 *
 * Displays the site header with navigation, theme switcher, and waitlist button.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Preconnect to external resources for improved performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://lh3.googleusercontent.com">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 font-sans transition-colors duration-300'); ?>>
<?php wp_body_open(); ?>

<nav class="fixed w-full z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-pink-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Logo / Site Title -->
        <div class="flex items-center gap-2">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-primary font-display text-2xl font-bold tracking-tight hover:opacity-80 transition-opacity">
                HOOKED ON A NEEDLE
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8 font-medium">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'hooan_fallback_menu',
                'walker'         => new HOOAN_Nav_Walker(),
            ));
            ?>
        </nav>

        <!-- Right Side Actions -->
        <div class="flex items-center gap-4">
            <!-- Theme Switcher -->
            <button
                id="theme-toggle"
                class="p-2 rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 transition-colors"
                aria-label="<?php esc_attr_e('Toggle dark mode', 'hookedonaneedle'); ?>"
            >
                <span class="material-icons-outlined">dark_mode</span>
            </button>

            <!-- Join Waitlist Button (scrolls to form) -->
            <a
                href="#waitlist-form"
                class="hidden sm:block bg-primary text-white px-6 py-2 rounded-full font-medium hover:opacity-90 transition-opacity"
            >
                <?php _e('Join Waitlist', 'hookedonaneedle'); ?>
            </a>

            <!-- Mobile Menu Toggle -->
            <button
                id="mobile-menu-toggle"
                class="md:hidden p-2 rounded-full hover:bg-pink-50 dark:hover:bg-slate-800 transition-colors"
                aria-label="<?php esc_attr_e('Toggle menu', 'hookedonaneedle'); ?>"
                aria-expanded="false"
            >
                <span class="material-icons-outlined">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="mobile-menu md:hidden fixed top-20 left-0 w-full h-[calc(100vh-5rem)] bg-background-light dark:bg-background-dark z-40">
        <nav class="flex flex-col items-center gap-6 py-8 font-medium text-lg">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'hooan_fallback_menu_mobile',
                'walker'         => new HOOAN_Nav_Walker_Mobile(),
            ));
            ?>
            <a
                href="#waitlist-form"
                class="mt-4 bg-primary text-white px-8 py-3 rounded-full font-medium hover:opacity-90 transition-opacity"
            >
                <?php _e('Join Waitlist', 'hookedonaneedle'); ?>
            </a>
        </nav>
    </div>
</nav>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = menuToggle.querySelector('.material-icons-outlined');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('open');
            menuIcon.textContent = isExpanded ? 'menu' : 'close';
        });

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuIcon.textContent = 'menu';
            });
        });
    }
});
</script>
