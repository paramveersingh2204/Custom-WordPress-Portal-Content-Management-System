<?php
/**
 * Single blog post.
 *
 * @package fieldnote-shop
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main wrap" tabindex="-1">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'entry' ); ?>>
			<header class="page-header">
				<h1><?php the_title(); ?></h1>
				<p class="entry-meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="entry-figure"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php get_footer(); ?>
