<?php
/**
 * Search form with a real, programmatically associated label.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
$uid = wp_unique_id( 'search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Search the shop', 'fieldnote-shop' ); ?></label>
	<div class="search-form__row">
		<input type="search" id="<?php echo esc_attr( $uid ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off">
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<input type="hidden" name="post_type" value="product">
		<?php endif; ?>
		<button type="submit"><?php esc_html_e( 'Search', 'fieldnote-shop' ); ?></button>
	</div>
</form>
