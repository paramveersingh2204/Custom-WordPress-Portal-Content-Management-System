<?php
/**
 * Fallback template: blog, archives and search results.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main wrap" tabindex="-1">
	<header class="page-header">
		<h1>
			<?php
			if ( is_search() ) {
				/* translators: %s: search query */
				printf( esc_html__( 'Search results for "%s"', 'fieldnote-shop' ), esc_html( get_search_query() ) );
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				esc_html_e( 'Journal', 'fieldnote-shop' );
			}
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="post-list">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			?>
		</div>
		<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Previous page', 'fieldnote-shop' ), 'next_text' => __( 'Next page', 'fieldnote-shop' ) ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing matched. Try a different word, or browse the shop from the menu.', 'fieldnote-shop' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
