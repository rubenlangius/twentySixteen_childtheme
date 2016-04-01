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
	<?php if ( ! is_sticky() ) : ?>
		<!-- not a sticky post  -->
		<div class="container-fluid">
			<div class="row">
				<!-- standard post format -->
				<div class="col-xs-7 col-sm-12 col-md-9 pull-right excerpt-text">
					<?php the_category( ', ' ); ?>
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</div>
				<div class="col-xs-5 col-sm-3 col-md-3 pull-left image-excerpt">
					<?php twentysixteen_post_thumbnail(); ?>
				</div>
				<div class="hidden-xs col-sm-9 col-md-9 pull-right excerpt-text">
					<?php the_excerpt(); ?>	
				</div>
				<div class="clearfix"></div>
				<div style="height:60px;margin:0 15px;border-bottom:2px solid #f2f2f2;"></div>
			</div>
		</div>
	<?php endif; ?>
</article><!-- #post-## -->
