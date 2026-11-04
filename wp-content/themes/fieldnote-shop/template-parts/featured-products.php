<?php
/**
 * Featured products: ACF relationship -> Woo "featured" -> newest.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;

$heading = fns_field( 'featured_heading', false, __( 'Featured products', 'fieldnote-shop' ) );
$ids     = fns_field( 'featured_products', false, array() );
$ids     = is_array( $ids ) ? array_map( 'intval', $ids ) : array();

if ( ! $ids ) {
	$ids = wc_get_products( array( 'limit' => 4, 'featured' => true, 'status' => 'publish', 'return' => 'ids' ) );
}
if ( ! $ids ) {
	$ids = wc_get_products( array( 'limit' => 4, 'status' => 'publish', 'orderby' => 'date', 'order' => 'DESC', 'return' => 'ids' ) );
}
if ( ! $ids ) {
	return;
}
?>
<section class="featured wrap" aria-labelledby="featured-title">
	<h2 id="featured-title"><?php echo esc_html( $heading ); ?></h2>
	<ul class="card-grid" role="list">
		<?php
		foreach ( $ids as $product_id ) {
			echo '<li>';
			get_template_part( 'template-parts/product-card', null, array( 'product_id' => $product_id ) );
			echo '</li>';
		}
		?>
	</ul>
	<p><a class="button button--ghost" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'See all products', 'fieldnote-shop' ); ?></a></p>
</section>
