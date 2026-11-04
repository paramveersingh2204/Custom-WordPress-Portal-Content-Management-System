<?php
/**
 * 404: say what happened and what to do next.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main wrap" tabindex="-1">
	<header class="page-header">
		<h1><?php esc_html_e( 'This page does not exist', 'fieldnote-shop' ); ?></h1>
		<p class="page-intro"><?php esc_html_e( 'The link may be old or mistyped. Search for what you need, or go back to the shop.', 'fieldnote-shop' ); ?></p>
	</header>
	<?php get_search_form(); ?>
	<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
		<p><a class="button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Go to the shop', 'fieldnote-shop' ); ?></a></p>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
