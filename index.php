<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			$sticky = get_option( 'sticky_posts' );
			$args = array(
				'posts_per_page' => 1,
				'post__in'  => $sticky,
				'ignore_sticky_posts' => 1
			);
			$query = new WP_Query( $args );
			if ( isset($sticky[0]) ) :
				while ($query->have_posts()) : $query->the_post(); ?>
					<div class="container-fluid featured">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 excerpt-text pull-right">
								<span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
								<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 feature-image pull-left">
								<?php twentysixteen_post_thumbnail(); ?>
							</div>
							<div class="col-xs-12 col-sm-8 col-md-8 excerpt-text pull-right">
								<?php twentysixteen_excerpt(); ?>
							</div>
						</div>
					</div>
			<?php
			endwhile;
			endif;
			if ( !isset($sticky[0]) ){
				echo"<div class='page-header' style='margin-left:15px; margin-right:15px; margin-bottom:3.9em;'><h1 class='entry-title'>Blog Overzicht</h1></div>";
			}
			 ?>


			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				if (get_field( "frontpage" )) :
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				endif;
			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->

	</div><!-- .content-area -->

		<?php get_footer(); ?>

<?php get_sidebar(); ?>
