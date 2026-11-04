<?php
/**
 * Wrapper for every WooCommerce template (shop, product, cart, checkout, account).
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main wrap" tabindex="-1">
	<?php woocommerce_content(); ?>
</main>
<?php get_footer(); ?>
