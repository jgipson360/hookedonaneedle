# Hooked On A Needle — Custom WordPress Theme

A handcrafted WordPress theme for a crochet and fiber arts online store. Warm, responsive, accessible, and fully content-managed through ACF field groups.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- MySQL 5.7+
- WooCommerce 8.0+ (shop functionality)
- Advanced Custom Fields Pro 6.0+ (recommended — theme works without it using built-in defaults)

## Features

- **Light/Dark Mode** — toggle with persistent localStorage preference
- **Email Waitlist** — AJAX form with admin dashboard, CSV export, and email notifications
- **ACF-Powered Content** — every section editable from the WordPress admin
- **WooCommerce Shop** — custom product cards, category filtering, sorting, sidebar, and pagination
- **Custom Orders** — commission request form with process steps and trust signals
- **Learn Page** — educational content and philanthropy initiative
- **Social Hub** — community events, hot drops, and live engagement CTAs
- **SEO Module** — meta tags, Open Graph, and structured data
- **Responsive** — mobile-first with Tailwind CSS
- **Accessible** — ARIA labels, semantic HTML, 44px+ touch targets
- **Secure** — nonce verification, prepared statements, sanitized input, escaped output
- **Translation Ready** — full i18n support

## Installation

1. Copy the `hookedonaneedle` folder to `wp-content/themes/`
2. Install and activate [ACF Pro](https://www.advancedcustomfields.com/pro/) (optional but recommended)
3. Activate the theme in **Appearance → Themes**
4. Create pages and assign templates:

| Page | Template |
|------|----------|
| Home | Homepage |
| About | About |
| Shop | *(WooCommerce default)* |
| Custom Orders | Custom Orders |
| Learn | Learn |
| Social | Social Hub |

5. Set the homepage under **Settings → Reading → A static page**

On activation the theme creates the waitlist database table, registers ACF field groups, and flushes rewrite rules.

## Theme Structure

```
hookedonaneedle/
├── style.css                       # Theme metadata + custom styles
├── functions.php                   # Setup, hooks, asset loading, helpers
├── header.php / footer.php         # Global header and footer
├── index.php                       # Fallback template
│
├── page-home.php                   # Homepage
├── page-about.php                  # About
├── page-custom-orders.php          # Custom orders
├── page-learn.php                  # Learn
├── page-social.php                 # Social hub
│
├── inc/
│   ├── acf-fields.php              # ACF field group definitions + defaults
│   ├── custom-orders.php           # Commission form processing
│   ├── waitlist-handler.php        # Waitlist AJAX + DB logic
│   ├── waitlist-admin.php          # Waitlist admin UI
│   ├── woocommerce-setup.php       # WooCommerce integration
│   └── seo.php                     # SEO meta, Open Graph, structured data
│
├── template-parts/
│   ├── hero-section.php            # Homepage hero
│   ├── featured-creations.php      # Featured products grid
│   ├── product-features.php        # Product highlights
│   ├── email-form.php              # Waitlist form
│   ├── waitlist-modal.php          # Waitlist modal dialog
│   ├── custom-orders-*.php         # Custom orders sections
│   ├── social-*.php                # Social hub sections
│   └── shop/
│       ├── product-card.php        # Product card component
│       ├── shop-hero.php           # Shop hero banner
│       ├── shop-sidebar.php        # Category filters
│       ├── shop-toolbar.php        # Sort controls
│       ├── pagination.php          # Shop pagination
│       ├── cart-badge.php          # Header cart icon
│       ├── product-badge.php       # Sale/new badges
│       └── product-details-section.php
│
├── woocommerce/
│   ├── archive-product.php         # Product archive override
│   ├── content-product.php         # Product loop override
│   └── single-product.php          # Single product override
│
└── assets/
    ├── css/                        # Page-specific stylesheets (conditionally loaded)
    ├── js/                         # Vanilla ES6+ scripts (no build step)
    └── images/                     # Default/fallback images
```

## Content Editing

All content is managed through ACF fields in the WordPress admin. Each page template pulls from its own field group.

**Homepage sections:** hero (headline, tagline, image), featured creations (repeater with images), product features (quote + highlights), footer (social links, nav groups, copyright).

**Other pages:** About (story, values, artisan profile), Custom Orders (form config, process steps, testimonials), Learn (tutorials, philanthropy), Social Hub (events, hot drops, live CTAs).

**Waitlist management:** **Settings → Waitlist** in the admin — view entries, export CSV, delete entries.

## Design Tokens

| Token | Value | Usage |
|-------|-------|-------|
| Primary | `#8B4A4E` | CTAs, links, accents |
| Secondary | `#EACAC6` | Decorative backgrounds |
| Background Light | `#FDF6F5` | Light mode background |
| Background Dark | `#1A1616` | Dark mode background |
| Display font | Playfair Display | Headings |
| Body font | Quicksand | Body text |

Dark mode uses Tailwind's `class` strategy — toggled via JS on the `<html>` element.

## Theme Hooks

Available action hooks for customization:

- `hooan_before_hero` / `hooan_after_hero` — around the hero section
- `hooan_before_footer` — before the footer
- `hooan_waitlist_submitted` — after a successful waitlist signup (receives email, ID, name)

## Performance

- Lazy loading with `loading="lazy"` and `decoding="async"` for below-fold images
- `fetchpriority="high"` for above-fold images
- Preconnect hints for external resources
- Conditional asset loading — page-specific CSS/JS only loads on its template
- Tailwind via CDN — no build step, no unused CSS in development
- No jQuery dependency

## Security

- Nonce verification on all AJAX and form submissions
- `sanitize_email()`, `sanitize_text_field()`, `intval()` on all input
- `esc_html()`, `esc_url()`, `esc_attr()` on all output
- `$wpdb->prepare()` for all database queries

## Troubleshooting

**ACF fields not showing** — Verify ACF Pro is active and the page uses the correct template. Clear any caching plugins.

**Waitlist form not submitting** — Check the browser console for JS errors. If the database table is missing, deactivate and reactivate the theme to recreate it.

**Dark mode not persisting** — Requires localStorage (won't work in private browsing). Check for JS errors blocking `theme-switcher.js`.

**Images not loading** — Verify URLs are accessible and the uploads directory has proper permissions (`755`).

## License

GNU General Public License v2 or later.

## Credits

- [Tailwind CSS](https://tailwindcss.com)
- [Google Fonts](https://fonts.google.com) — Playfair Display, Quicksand
- [Material Icons](https://fonts.google.com/icons)
- [Advanced Custom Fields](https://www.advancedcustomfields.com)
