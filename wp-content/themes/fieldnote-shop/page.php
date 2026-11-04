<?php
/**
 * Standard page with optional ACF intro sentence.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main wrap" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		$intro = fns_field( 'page_intro' );
		?>
		<article <?php post_class( 'entry' ); ?>>
			<header class="page-header">
				<h1><?php the_title(); ?></h1>
				<?php if ( $intro ) : ?>
					<p class="page-intro"><?php echo esc_html( $intro ); ?></p>
				<?php endif; ?>
			</header>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php get_footer(); ?>
