/**
 * Theme Switcher
 *
 * Handles light/dark mode toggle with localStorage persistence.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

class ThemeSwitcher {
    constructor() {
        this.STORAGE_KEY = 'hooan_theme_preference';
        this.DARK_CLASS = 'dark';
        this.button = null;
        this.init();
    }

    /**
     * Initialize the theme switcher
     */
    init() {
        // Load saved preference on page load
        this.loadPreference();

        // Set up button click handler when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupButton());
        } else {
            this.setupButton();
        }
    }

    /**
     * Set up the toggle button event listener
     */
    setupButton() {
        this.button = document.getElementById('theme-toggle');
        if (this.button) {
            this.button.addEventListener('click', () => this.toggleTheme());
        }
    }

    /**
     * Toggle between light and dark themes
     */
    toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains(this.DARK_CLASS);

        if (isDark) {
            html.classList.remove(this.DARK_CLASS);
            this.savePreference('light');
        } else {
            html.classList.add(this.DARK_CLASS);
            this.savePreference('dark');
        }

        this.updateButtonIcon();
    }

    /**
     * Save theme preference to localStorage
     *
     * @param {string} theme - 'light' or 'dark'
     */
    savePreference(theme) {
        try {
            localStorage.setItem(this.STORAGE_KEY, theme);
        } catch (e) {
            // localStorage not available, silently fail
            console.warn('Unable to save theme preference:', e);
        }
    }

    /**
     * Load theme preference from localStorage
     */
    loadPreference() {
        try {
            const savedTheme = localStorage.getItem(this.STORAGE_KEY);

            if (savedTheme === 'dark') {
                document.documentElement.classList.add(this.DARK_CLASS);
            } else if (savedTheme === 'light') {
                document.documentElement.classList.remove(this.DARK_CLASS);
            } else {
                // Check system preference
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add(this.DARK_CLASS);
                }
            }
        } catch (e) {
            // localStorage not available, silently fail
            console.warn('Unable to load theme preference:', e);
        }
    }

    /**
     * Apply a specific theme
     *
     * @param {string} theme - 'light' or 'dark'
     */
    applyTheme(theme) {
        const html = document.documentElement;

        if (theme === 'dark') {
            html.classList.add(this.DARK_CLASS);
        } else {
            html.classList.remove(this.DARK_CLASS);
        }

        this.savePreference(theme);
        this.updateButtonIcon();
    }

    /**
     * Update the button icon based on current theme
     */
    updateButtonIcon() {
        if (!this.button) return;

        const icon = this.button.querySelector('.material-icons-outlined');
        if (!icon) return;

        const isDark = document.documentElement.classList.contains(this.DARK_CLASS);
        icon.textContent = isDark ? 'light_mode' : 'dark_mode';
    }
}

// Initialize theme switcher
const themeSwitcher = new ThemeSwitcher();
