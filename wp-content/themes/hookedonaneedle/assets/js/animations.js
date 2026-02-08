/**
 * UI Animations
 *
 * Handles scroll-triggered animations and other UI effects.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

class Animations {
    constructor() {
        this.init();
    }

    /**
     * Initialize animations
     */
    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    /**
     * Set up animations
     */
    setup() {
        this.setupFadeInAnimations();
        this.setupScrollAnimations();
        this.setupHoverEffects();
    }

    /**
     * Set up fade-in animations for elements on page load
     */
    setupFadeInAnimations() {
        const elements = document.querySelectorAll('.animate-fade-in');

        elements.forEach((el, index) => {
            // Set initial state
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';

            // Animate with delay
            setTimeout(() => {
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 150);
        });
    }

    /**
     * Set up scroll-triggered animations using Intersection Observer
     */
    setupScrollAnimations() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements with scroll animation class
        const scrollElements = document.querySelectorAll('.animate-on-scroll');
        scrollElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(el);
        });
    }

    /**
     * Set up hover effects for interactive elements
     */
    setupHoverEffects() {
        // Featured creation cards hover effect
        const cards = document.querySelectorAll('.featured-creation-card');

        cards.forEach(card => {
            const image = card.querySelector('img');

            card.addEventListener('mouseenter', () => {
                if (image) {
                    image.style.transform = 'scale(1.05)';
                }
            });

            card.addEventListener('mouseleave', () => {
                if (image) {
                    image.style.transform = 'scale(1)';
                }
            });
        });
    }
}

// Initialize animations
new Animations();
