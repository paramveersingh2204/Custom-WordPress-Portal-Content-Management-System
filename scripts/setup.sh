#!/usr/bin/env bash
# One-shot bootstrap: installs WordPress, WooCommerce, ACF, activates the theme,
# creates pages, a menu and six sample products.
set -euo pipefail

WP="docker compose run --rm -T wpcli wp"
URL="http://localhost:8080"

echo "Waiting for WordPress files..."
for i in $(seq 1 40); do
  $WP db check >/dev/null 2>&1 && break
  sleep 3
done

$WP core install --url="$URL" --title="Fieldnote Goods" \
  --admin_user=admin --admin_password=admin --admin_email=admin@example.com --skip-email

$WP option update blogdescription "Notebooks, pens and paper goods for people who write things down"
$WP rewrite structure '/%postname%/' --hard
$WP plugin install woocommerce advanced-custom-fields --activate
$WP theme activate fieldnote-shop
$WP option update woocommerce_currency CAD
$WP option update woocommerce_default_country "CA:ON"

# Front page ------------------------------------------------------------
HOME_ID=$($WP post create --post_type=page --post_title="Home" --post_status=publish \
  --post_content="<!-- wp:paragraph --><p>Every product here is chosen because someone actually uses it every day.</p><!-- /wp:paragraph -->" --porcelain)
$WP option update show_on_front page
$WP option update page_on_front "$HOME_ID"
$WP post meta update "$HOME_ID" hero_heading "Paper that keeps up with your thinking"
$WP post meta update "$HOME_ID" hero_text "Notebooks, pens and desk tools made in small runs. Lay-flat binding, fountain-pen-safe paper, no gimmicks."
$WP post meta update "$HOME_ID" hero_cta_label "Shop notebooks"
$WP post meta update "$HOME_ID" hero_cta_url "$URL/shop/"
$WP post meta update "$HOME_ID" featured_heading "Most reordered"

# Sample catalogue -------------------------------------------------------
cat_id() { $WP wc product_cat create --name="$1" --user=admin --porcelain; }
NOTEBOOKS=$(cat_id "Notebooks")
PENS=$(cat_id "Pens")
DESK=$(cat_id "Desk")

add_product() { # name price category_id short_desc badge material care
  local id
  id=$($WP wc product create --name="$1" --type=simple --regular_price="$2" \
    --categories="[{\"id\":$3}]" --short_description="$4" \
    --description="$4 Built to be used daily and refilled, not replaced." \
    --user=admin --porcelain)
  [ -n "${5:-}" ] && $WP post meta update "$id" product_badge "$5" >/dev/null
  [ -n "${6:-}" ] && $WP post meta update "$id" product_material "$6" >/dev/null
  [ -n "${7:-}" ] && $WP post meta update "$id" product_care "$7" >/dev/null
  echo "$id"
}

add_product "Field Notebook, A5 dot grid" 18 "$NOTEBOOKS" "120 gsm paper, lay-flat thread binding, 192 pages." "new" "Recycled paper, linen cloth cover" "Keep dry. Wipe cover with a damp cloth." >/dev/null
add_product "Pocket Notebook 3-pack" 14 "$NOTEBOOKS" "Three staple-bound pocket notebooks, 48 pages each." "" "Recycled kraft cover" "" >/dev/null
add_product "Weekly Planner, undated" 24 "$NOTEBOOKS" "Two-page weekly spread with a notes column." "restock" "100 gsm paper, vegan leather cover" "" >/dev/null
add_product "Brass Fountain Pen" 62 "$PENS" "Solid brass body, steel nib, converter included." "limited" "Brass, stainless steel nib" "Rinse nib with water if not used for a month." >/dev/null
add_product "Gel Pen 5-pack" 12 "$PENS" "0.5 mm, quick-dry black ink, refillable barrel." "" "Aluminium barrel" "" >/dev/null
add_product "Walnut Desk Tray" 38 "$DESK" "Holds a notebook, two pens and a phone." "" "Solid walnut, oil finish" "Re-oil once a year." >/dev/null

# Pages + menu -----------------------------------------------------------
ABOUT_ID=$($WP post create --post_type=page --post_title="About" --post_status=publish \
  --post_content="Fieldnote Goods is a demo store built for the accessible WordPress theme project." --porcelain)
SHOP_ID=$($WP option get woocommerce_shop_page_id)
$WP menu create "Primary" >/dev/null
$WP menu item add-post primary "$SHOP_ID" >/dev/null
$WP menu item add-post primary "$ABOUT_ID" >/dev/null
$WP menu location assign primary primary

echo
echo "Done."
echo "  Store:  $URL"
echo "  Admin:  $URL/wp-admin   (admin / admin — local use only)"
