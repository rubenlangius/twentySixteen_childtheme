<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php 
				$page = get_page_by_path('recepten-overzicht');
				$the_query = new WP_Query( 'page_id='.$page->ID );
				while ( $the_query->have_posts() ) :
					$the_query->the_post(); ?>
				    <h1 class="entry-title">
				    <?php the_title(); ?>
					</h1>
				    <?php the_content(); ?>
				<?php    
				endwhile;
				wp_reset_postdata();
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();?>

				<div class="container-fluid no-padding page-header" style="border:none;">
			<div class="row">
				<!-- standard post format -->
				<div class="col-xs-12 col-sm-12 col-md-7 pull-right excerpt-text">
					<?php the_category( ', ' ); ?>
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-5 pull-left image-excerpt">
					<?php twentysixteen_post_thumbnail(); ?>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-7 pull-right excerpt-text">
					<?php the_excerpt(); ?>	
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 excerpt-footer"></div>
			</div>
		</div>

			<?php
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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
