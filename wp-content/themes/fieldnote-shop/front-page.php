<?php
/**
 * Home page: ACF hero, featured products, then the editor content.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/hero' );
		if ( class_exists( 'WooCommerce' ) ) {
			get_template_part( 'template-parts/featured-products' );
		}
		if ( trim( get_the_content() ) ) :
			?>
			<div class="wrap entry-content entry-content--home"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>
</main>
<?php get_footer(); ?>
