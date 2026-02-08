# Hooked On A Needle - Custom WordPress Theme

A cozy crochet fiber arts theme featuring a modern design with light/dark mode support, email waitlist functionality, and ACF-powered content management.

## Requirements

- **WordPress**: 6.0 or higher
- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Advanced Custom Fields Pro**: 6.0 or higher (recommended for content management)

## Features

- 🎨 **Light/Dark Mode**: Toggle between color schemes with persistent preference
- 📧 **Email Waitlist**: Capture visitor emails with AJAX-powered form submission
- ✏️ **ACF Integration**: Edit all homepage content through WordPress admin
- 📱 **Responsive Design**: Mobile-first approach with Tailwind CSS
- ⚡ **Performance Optimized**: Lazy loading, preconnect hints, minimal dependencies
- 🔒 **Secure**: Nonce verification, input sanitization, and validation
- ♿ **Accessible**: ARIA labels, semantic HTML, touch-friendly targets
- 🌐 **Translation Ready**: Full internationalization support

## Installation

### Step 1: Install Theme Files

Copy the `hookedonaneedle` theme folder to your WordPress themes directory:

```
wp-content/themes/hookedonaneedle/
```

### Step 2: Install ACF Pro (Recommended)

This theme works best with Advanced Custom Fields Pro. Without ACF Pro, the theme will display default placeholder content.

1. Purchase and download ACF Pro from [advancedcustomfields.com](https://www.advancedcustomfields.com/pro/)
2. Go to **Plugins > Add New > Upload Plugin**
3. Upload the ACF Pro zip file and activate

> **Note**: The theme will function without ACF Pro using built-in default content.

### Step 3: Activate the Theme

Go to **Appearance > Themes** in WordPress admin and activate "Hooked On A Needle"

On activation, the theme will:
- Create the waitlist database table
- Register ACF field groups (if ACF Pro is active)
- Flush rewrite rules

### Step 4: Create Homepage

1. Go to **Pages > Add New**
2. Title the page "Home" or similar
3. In the Page Attributes panel, set Template to "Homepage"
4. Publish the page

### Step 5: Set as Front Page

1. Go to **Settings > Reading**
2. Select "A static page" under "Your homepage displays"
3. Choose your homepage from the dropdown
4. Save Changes

## Theme Structure

```
hookedonaneedle/
├── style.css                 # Theme metadata and custom styles
├── functions.php             # Theme setup, hooks, and includes
├── index.php                 # Main template file
├── header.php                # Site header with navigation
├── footer.php                # Site footer
├── page-home.php             # Homepage template
├── inc/
│   ├── acf-fields.php        # ACF field group definitions
│   ├── waitlist-handler.php  # Waitlist form processing
│   └── waitlist-admin.php    # Admin interface for waitlist
├── template-parts/
│   ├── hero-section.php      # Hero section component
│   ├── featured-creations.php # Featured products grid
│   ├── product-features.php  # Features section
│   └── email-form.php        # Waitlist form component
├── assets/
│   ├── css/
│   │   └── custom.css        # Additional custom styles
│   ├── js/
│   │   ├── theme-switcher.js # Dark/light mode toggle
│   │   ├── waitlist-form.js  # Form validation and submission
│   │   └── animations.js     # UI animations
│   └── images/               # Theme images and placeholders
└── README.md                 # This file
```

## Content Editing

### Homepage Sections

All homepage content is editable through ACF fields:

1. **Hero Section**
   - Announcement badge text
   - Three-part headline (main, emphasis, secondary)
   - Subtitle/tagline
   - Hero featured image

2. **Featured Creations**
   - Section title and subtitle
   - Lookbook link URL
   - Repeatable creation items (image, title, description)

3. **Product Features**
   - Quote text
   - Feature highlights (title, subtitle pairs)

4. **Footer**
   - Description text
   - Social media links
   - Navigation link groups (Explore, Support)
   - Copyright text

### Managing the Waitlist

Access **Settings > Waitlist** in WordPress admin to:
- View all waitlist entries
- Export entries to CSV
- Delete individual entries
- See total subscriber count

## Development

### Tailwind CSS

This theme uses Tailwind CSS via CDN for rapid development. The configuration is defined inline in `functions.php`.

**Custom Colors:**
- Primary: `#8B4A4E` (deep warm rose)
- Secondary: `#EACAC6` (soft pastel pink)
- Background Light: `#FDF6F5` (soft cream/pink)
- Background Dark: `#1A1616` (dark charcoal)

**Custom Fonts:**
- Display: Playfair Display (headings)
- Sans: Quicksand (body text)

### Hooks and Filters

The theme provides these hooks for customization:

- `hooan_before_hero` - Before hero section
- `hooan_after_hero` - After hero section
- `hooan_before_footer` - Before footer section
- `hooan_waitlist_submitted` - After successful email submission

## Troubleshooting

### ACF Fields Not Showing

1. Ensure ACF Pro is installed and activated
2. Check that the page uses the "Homepage" template
3. Verify field group location rules are set correctly
4. Clear any caching plugins

### Waitlist Form Not Working

1. Check browser console for JavaScript errors
2. Verify AJAX URL is accessible (check for plugin conflicts)
3. Ensure nonce is being generated correctly
4. Verify the waitlist database table exists:
   - Deactivate and reactivate the theme to recreate the table
   - Check database permissions

### Theme Switcher Not Persisting

1. Check if localStorage is available (not in private browsing)
2. Verify theme-switcher.js is loading correctly
3. Check for JavaScript errors blocking execution

### Images Not Loading

1. Verify image URLs are accessible
2. Check for CORS issues with external images
3. Ensure uploads directory has proper permissions

### Mobile Menu Not Working

1. Check for JavaScript errors in browser console
2. Verify the mobile menu toggle element exists in the DOM
3. Test on different browsers

## Database

### Waitlist Table Schema

The theme creates a `{prefix}_waitlist_emails` table with:

| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT UNSIGNED | Auto-increment primary key |
| email | VARCHAR(255) | Email address (unique) |
| created_at | DATETIME | Timestamp of submission |

### Recreating the Database Table

If the waitlist table is missing:
1. Go to **Appearance > Themes**
2. Activate a different theme temporarily
3. Re-activate "Hooked On A Needle"

## Performance

### Built-in Optimizations

- **Lazy Loading**: Below-fold images use `loading="lazy"`
- **Preconnect**: External resources have preconnect hints
- **Minimal Dependencies**: Uses CDN for Tailwind, no heavy frameworks
- **Async Decoding**: Images use `decoding="async"` for non-blocking decode

### Recommended Additional Optimizations

1. Install a caching plugin (WP Super Cache, W3 Total Cache)
2. Use a CDN for static assets
3. Optimize uploaded images before upload
4. Enable GZIP compression on your server

## Security

### Built-in Security Features

- Nonce verification for all AJAX requests
- Input sanitization using WordPress functions
- Prepared SQL statements to prevent injection
- Escaped output to prevent XSS

## License

GNU General Public License v2 or later

## Credits

- Tailwind CSS - https://tailwindcss.com
- Google Fonts - Playfair Display, Quicksand
- Material Icons - https://fonts.google.com/icons
- Advanced Custom Fields - https://www.advancedcustomfields.com
