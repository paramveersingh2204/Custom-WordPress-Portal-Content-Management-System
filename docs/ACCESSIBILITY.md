# Accessibility notes

Target: **WCAG 2.2 Level AA**. This is a record of what the theme does and where, plus a manual test checklist. It is not a formal conformance claim: always test your own content and plugins.

## How the theme meets each criterion

| WCAG | Requirement | Where |
|---|---|---|
| 1.1.1 Non-text content | Hero image alt comes from an ACF field; empty = decorative (`alt=""`). Product-card images are decorative because the title link names the product. | `template-parts/hero.php`, `product-card.php` |
| 1.3.1 Info and relationships | Semantic landmarks (`header`, `nav`, `main`, `footer`), one `h1` per page, spec list is a `<dl>`, form labels are programmatically tied to inputs. | `header.php`, `footer.php`, `searchform.php`, `inc/woocommerce.php` |
| 1.4.1 Use of colour | Badges are text. Required and invalid form fields add text cues, not only red. | `woocommerce.css` |
| 1.4.3 / 1.4.11 Contrast | Body text 14:1, muted 7.4:1, links 7.6:1. Input and button borders 3:1 or better. | `:root` tokens in `main.css` |
| 1.4.4 Resize text | `rem`/`em` units and `em` breakpoints; no fixed heights on text containers. | `main.css` |
| 1.4.10 Reflow | Single column at 320 px, tables stacked by WooCommerce. | `main.css`, `woocommerce.css` |
| 1.4.12 Text spacing | No fixed line-height containers; spacing survives user overrides. | `main.css` |
| 2.1.1 / 2.1.2 Keyboard | All controls are native links or buttons. Submenus open from a real button and close with Escape. | `assets/js/main.js` |
| 2.4.1 Bypass blocks | Skip link is the first focusable element. | `header.php` |
| 2.4.3 / 2.4.7 Focus | DOM order matches visual order. Focus ring is never removed. | `main.css` |
| 2.4.4 Link purpose | One stretched link per card, named by the product title. | `product-card.php` |
| 2.4.11 Focus not obscured | Header is not sticky. | `main.css` |
| 2.5.8 Target size | 44 px minimum on buttons, menu links, cart link, quantity, remove-item. | `--target` token |
| 3.3.1 / 3.3.2 Errors, labels | Woo's inline errors are kept and styled; invalid fields get a text suffix. | `woocommerce.css` |
| 4.1.2 Name, role, value | Menu and submenu toggles expose `aria-expanded` and `aria-controls`. | `assets/js/main.js` |
| 4.1.3 Status messages | Cart add/remove/update announced through a polite live region. | `header.php`, `main.js` |
| Prefs | `prefers-reduced-motion` and `forced-colors` handled. | `main.css` |

## Manual checklist

Run on: home, shop, product, cart, checkout, my account, 404.

- [ ] Tab from the top: first stop is "Skip to main content", and it works.
- [ ] Every interactive element is reachable and operable with keyboard only.
- [ ] Focus is always visible and never hidden behind other content.
- [ ] Submenu: Enter/Space opens it, Escape closes it and returns focus to the toggle.
- [ ] Mobile menu: opens, traps nothing, closes with Escape.
- [ ] Add to cart: screen reader announces "Item added to your cart."
- [ ] 200% browser zoom and 320 px viewport: no horizontal scroll, nothing clipped.
- [ ] Windows High Contrast / forced colors: buttons and cards still have visible edges.
- [ ] Checkout: submit with empty required fields, errors are announced and linked to fields.
- [ ] Heading outline makes sense (one `h1`, no skipped levels).

## Known limits

- Third-party payment widgets (Stripe, PayPal) and plugins are outside the theme's control.
- WooCommerce's gallery lightbox (PhotoSwipe) is its own component; test it with your screen reader.
- Editors must write meaningful alt text and link text; the ACF fields prompt for it.
