<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="container featured">
			<div class="col-sm-6 feature-image">
				<?php twentysixteen_post_thumbnail(); ?>
			</div>
			<div class="col-sm-6 sidetext">
				<span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<?php twentysixteen_excerpt(); ?>
			</div>
		</div>
	<?php else: ?>


	<header class="col-sm-12">		
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->
	<div class="col-sm-5">
		<?php twentysixteen_post_thumbnail(); ?>
	</div>
	<div class="col-sm-6">
		<?php twentysixteen_excerpt(); ?>
	</div>


	<?php endif; ?>
</article><!-- #post-## -->
