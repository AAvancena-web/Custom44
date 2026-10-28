# Custom 44 WordPress Theme

Premium WooCommerce theme for [custom44.com.au](https://custom44.com.au/), built by Digital Movement.

Templates included:

| Page | File |
| --- | --- |
| Global header | `header.php` |
| Global footer (with contact info, Google Map and form above it) | `footer.php`, `template-parts/contact-section.php` |
| Homepage | `front-page.php` |
| Category page (product archive) | `woocommerce/archive-product.php` |
| Product page | `woocommerce/single-product.php`, `woocommerce/content-single-product.php` |
| Product card (whole card clickable) | `template-parts/product-card.php` |

## Install

1. Download this repository as a ZIP, rename the folder inside to `custom44`, and zip it again (or copy the folder into `wp-content/themes/`).
2. Appearance > Themes > Activate **Custom 44**.
3. Settings > Reading: set a static front page (any page). `front-page.php` renders the homepage.
4. Appearance > Menus: assign menus to **Primary Menu**, **Footer: Shop** and **Footer: Helpful Links**. Until assigned, a built-in menu matching the current site is shown.
5. Appearance > Customize > Site Identity: upload the logo (falls back to the current site logo).
6. Appearance > Customize > **Custom 44 Settings**: phone, email, location, map query, banner text and images, social links, optional reviews widget shortcode and optional form plugin shortcode.
7. Optional: add filter widgets (e.g. WooCommerce product filters) to **Shop Sidebar (Category pages)**. Without widgets, a category tree and help card show instead.

## Notes

* **Layout widths:** `.container` is max 1440px on desktop/laptop and max 1880px on screens 1600px and wider.
* **Header:** phone icon in a dark circle with a border sits immediately left of the hamburger. Hamburger appears below 1200px.
* **Mobile:** floating "Call Now" button fixed at the bottom centre on screens under 768px.
* **Banners** (homepage hero, category hero) display instantly. Only sections below the banner use scroll reveal.
* **Animations:** scroll reveals, counters, animated bulk tier bars, marquee, parallax images, spotlight hover on service cards, header shrink and scroll progress bar. All respect `prefers-reduced-motion`.
* **CTAs** all use solid backgrounds. Centered headings and paragraphs have no max-width.
* **No em dashes:** content filters replace em/en dashes, product cards show price ranges as "$min - $max each" (plain hyphen, matching the current site), the product page price still shows "From $x", and the title separator is `|`.
* **Contact form:** built-in form posts to `admin-post.php`, emails the address set in the Customizer (honeypot + nonce protected). Paste a Gravity Forms / WPForms / CF7 shortcode in the Customizer to replace it.
* **Product page:** standard WooCommerce hooks are preserved, so the existing quote cart and product options plugins keep working. Theme additions (brand/SKU row, bulk tier table, trust points, help card, print guide) are attached via hooks in `inc/woocommerce.php`. Optional `.c44-opt`, `.c44-swatch`, `.c44-size`, `.c44-spot` classes style a step-by-step configurator.
* Images default to existing uploads on custom44.com.au (`/wp-content/uploads/...`) so the theme looks complete on the live site immediately.

## Feedback round 2 (Oct 2026)

* Brand yellow is now the logo yellow `#FFF301` (`--accent` in `assets/css/main.css`).
* Homepage: "Buy more, save more" calculator in the banner, Value Packs section (pulls the `value-packs` category when it exists, otherwise the current site's packs), Recent work gallery shows the 8 latest posts (4 columns x 2 rows) from @custom.44 (paste a long-lived Instagram access token under **Social & Reviews**; refreshed automatically and cached for an hour), or an Instagram feed plugin shortcode such as Smash Balloon, or the photos set in **Recent Work Photos** as a fallback.
* Menu fallback mirrors the live menu, including Value Packs.
* Map is pinned to the Custom 44 Pty Ltd Google Business Profile via **Contact Details & Map > Google Business Profile CID**. Rating and review count are set under **Homepage Banner**.
* Category banner is compact so products show above the fold; long descriptions get a "Read more" toggle.
* Product page: Google rating link, light tier box with "Add N more to unlock X% off" progress, colour swatches (theme swatches and WooCommerce colour dropdowns), Total quantity / Total price box above the add to quote button, and Google reviews in the reviews tab.

## Static previews

`_preview/index.html`, `_preview/category.html` and `_preview/product.html` are rendered from the real templates with sample products (built with `php _preview/build/build.php`). Open them in a browser to review the design without WordPress. The root `index.html` just redirects GitHub Pages visitors to `_preview/index.html`; it and the `_preview` folder can be deleted on the live server.
