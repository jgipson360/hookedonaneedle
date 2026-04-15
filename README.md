# 🧶 Hooked On A Needle

A custom WordPress theme and development environment for a handmade crochet and fiber arts online store. Built from scratch with a focus on warm, artisanal design, performance, accessibility, and a smooth content editing experience.

**Live site:** [hookedonaneedle.com](https://hookedonaneedle.com)

---

## About the Project

Hooked On A Needle is a real small business — a crochet artist selling handmade pieces online. This repo contains the full custom WordPress theme and the local development environment used to build it.

Every page, component, and interaction was designed and implemented specifically for this store. No starter themes, no page builders — just a clean WordPress theme built on Tailwind CSS, vanilla JavaScript, WooCommerce, and Advanced Custom Fields.

### What's Here

- A complete custom WordPress theme (`wp-content/themes/hookedonaneedle/`)
- Dockerized local development environment
- CI pipeline with PHP linting and WordPress coding standards
- Automated SFTP deployment to production via GitHub Actions

## Features

**Storefront & Commerce**
- WooCommerce integration with custom product cards, filtering, sorting, and pagination
- Custom orders page with commission request form and admin email notifications
- Email waitlist with AJAX submission, admin dashboard, and CSV export

**Pages**
- Homepage with hero, featured creations grid, product highlights, and waitlist CTA
- About page telling the maker's story
- Learn page covering the Hats for the Homeless philanthropy initiative
- Social hub with community events, hot drops, and live engagement CTAs
- Full shop with category filtering, sidebar, and custom single product layout

**Design & UX**
- Light/dark mode with persistent preference (localStorage)
- Mobile-first responsive design across all pages
- Scroll-driven animations and hover interactions
- Custom color palette and typography (Playfair Display + Quicksand)

**Under the Hood**
- All content editable through ACF field groups — no hardcoded copy
- Graceful fallbacks when ACF Pro isn't installed (default content renders)
- SEO meta tags, Open Graph, and structured data via built-in SEO module
- Nonce verification, prepared statements, input sanitization, output escaping
- Lazy loading, preconnect hints, async decoding, conditional asset loading
- ARIA labels, semantic HTML, accessible touch targets
- Full internationalization support

## Tech Stack

| Layer | Choice |
|-------|--------|
| CMS | WordPress 6.0+ |
| Commerce | WooCommerce 8.0+ |
| Content fields | Advanced Custom Fields Pro |
| Styling | Tailwind CSS 3.x (CDN) |
| JavaScript | Vanilla ES6+ (no jQuery, no build step) |
| Fonts | Google Fonts (Playfair Display, Quicksand) |
| Icons | Material Icons Outlined |
| Local dev | Docker Compose (WordPress + MySQL 8.0) |
| CI | GitHub Actions (PHPCS + WordPress standards) |
| Deployment | GitHub Actions → SFTP to Bluehost |
| Analytics | Google Analytics (gtag.js) |

## Local Development

### Prerequisites

- [Docker Desktop](https://docs.docker.com/desktop/)

### Setup

```bash
git clone https://github.com/your-username/hookedonaneedle.git
cd hookedonaneedle
cp .env.example .env
docker compose up -d
```

Open [http://localhost:8888](http://localhost:8888) and complete the WordPress setup wizard.

Theme and plugin files are bind-mounted — edits are reflected immediately without restarting containers.

### Useful Commands

```bash
docker compose up -d          # Start
docker compose down            # Stop (data preserved)
docker compose down -v         # Stop and wipe all data
docker compose logs -f         # Tail logs
docker compose exec wordpress bash   # Shell into WordPress
```

### Database Backup & Restore

```bash
# Export
docker compose exec db mysqldump -uwordpress -pwordpress wordpress > backup.sql

# Import
docker compose exec -T db mysql -uwordpress -pwordpress wordpress < backup.sql
```

## Project Structure

```
hookedonaneedle/
├── docker-compose.yml
├── .env.example
├── .github/workflows/
│   ├── ci.yml              # PHP lint + PHPCS on push/PR
│   └── deploy.yml          # SFTP deploy to Bluehost on merge to main
└── wp-content/
    ├── themes/hookedonaneedle/   # ← The custom theme (see theme README)
    └── plugins/                  # ACF, WooCommerce, etc.
```

The theme has its own [detailed README](wp-content/themes/hookedonaneedle/README.md) covering file structure, content editing, hooks, and troubleshooting.

## Deployment

Merging to `main` triggers a GitHub Actions workflow that deploys the theme to Bluehost via SFTP. Only the theme directory is deployed — WordPress core and WooCommerce are managed through Bluehost's hosting tools.

The theme registers all ACF field groups in code, so fields work on any environment without import/export. The waitlist database table is created automatically on theme activation.

## License

GNU General Public License v2 or later.
