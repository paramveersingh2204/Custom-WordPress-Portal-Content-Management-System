# Fieldnote Shop — Accessible WordPress + WooCommerce Theme

A custom WordPress portal and content management system for a small online shop (notebooks, pens, desk goods). Editors manage the home page, product details and page intros through **Advanced Custom Fields (ACF)**; the front end is a hand-built, mobile-first theme designed to **WCAG 2.2 AA**.

**Stack:** WordPress 6 · PHP 8.2 · MySQL 8 · WooCommerce · ACF · vanilla JS · hand-written CSS (no build step)

## What's inside

| Area | What it does |
|---|---|
| **Custom fields (ACF)** | Field groups are registered in code (`inc/acf-fields.php`): home hero, featured products, per-product details (badge, materials, dimensions, care, eco flag) and page intros. |
| **Template logic** | `front-page.php`, `template-parts/*`, `woocommerce.php`, `page.php`, `single.php`, `404.php`, `searchform.php`. Featured products fall back from ACF picks to Woo "featured" to newest. |
| **Fallbacks** | `fns_field()` reads ACF if active, otherwise plain post meta, so deactivating the plugin never breaks the site. |
| **Responsive CSS** | Mobile-first grid layout, `em` breakpoints (layout follows browser zoom), fluid type scale, usable at 320 px wide. |
| **Accessibility** | Skip link, landmarks, keyboard-operable menus, visible focus, live-region cart updates, 44 px targets, reduced-motion and forced-colors support. See [docs/ACCESSIBILITY.md](docs/ACCESSIBILITY.md). |
| **E-commerce** | Shop, product, cart, checkout and account pages restyled to meet contrast and target-size rules. |

## Quick start (Docker)

Requires Docker with Compose.

```bash
git clone https://github.com/<your-username>/fieldnote-wp-shop.git
cd fieldnote-wp-shop
docker compose up -d
./scripts/setup.sh
```

Then open <http://localhost:8080>. Admin: <http://localhost:8080/wp-admin> (`admin` / `admin`, local use only).

`setup.sh` installs WordPress, WooCommerce and ACF, activates the theme, creates the home page, a primary menu and six sample products with ACF values filled in.

## Manual install (existing WordPress site)

1. Copy `wp-content/themes/fieldnote-shop` into your site's `wp-content/themes/`.
2. Install and activate **WooCommerce** and **Advanced Custom Fields**.
3. Activate **Fieldnote Shop** under Appearance > Themes.
4. Create a page called "Home", then Settings > Reading > "A static page" > Homepage = Home.
5. Edit Home: fill in the **Hero** and **Featured products** fields.
6. Appearance > Menus: assign a menu to "Primary menu".

## Project structure

```
wp-content/themes/fieldnote-shop/
├── style.css                 theme header
├── functions.php             setup, assets, includes
├── header.php / footer.php   skip link, landmarks, nav, cart
├── front-page.php            hero + featured products
├── page.php / single.php / index.php / 404.php / comments.php / searchform.php
├── woocommerce.php           wrapper for all Woo views
├── template-parts/           hero, featured-products, product-card, content-card
├── inc/
│   ├── acf-fields.php        ACF field groups in code
│   ├── accessibility.php     pagination landmark, Customizer notice
│   ├── woocommerce.php       Woo hooks, badges, spec list, Care tab
│   └── helpers.php           fns_field(), menu fallback
└── assets/
    ├── css/main.css          tokens, layout, components
    ├── css/woocommerce.css   shop overrides
    └── js/main.js            menu, submenus, cart announcements
```

## Testing accessibility

Automated tools catch roughly a third of issues, so do both.

```bash
npx pa11y http://localhost:8080 --standard WCAG2AA
npx @axe-core/cli http://localhost:8080 http://localhost:8080/shop/
```

Manual pass (about 10 minutes per template): see the checklist in [docs/ACCESSIBILITY.md](docs/ACCESSIBILITY.md). Test with NVDA + Firefox or VoiceOver + Safari, keyboard only, 200% zoom, and a 320 px viewport.


## License

MIT. See [LICENSE](LICENSE).
