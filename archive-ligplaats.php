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
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4">
						<ul class="legenda">
						<li class="circle green"></li>
						<li>Marrekrite</li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="legenda">
						<li class="circle blue"></li>
						<li>Ankerplaats</li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="legenda">
						<li class="circle yellow"></li>
						<li>Haven</li>
						</ul>
					</div>
				</div>
			</div>

		<?php if ( have_posts() ) : ?>
			<div class="acf-map archivemap">
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				$location = get_field('locatie');

			?>
			<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>" cat='<?php echo get_the_category()[0]->name; ?>'>
				<?php the_post_thumbnail( 'medium' ); ?>
				<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>				
				<p class="address"><?php echo 'Lat : ' . $location['lat'] . ', Lng : ' . $location['lng']; ?></p>
				<?php the_excerpt(); ?>	
			</div>

			<?php
			// End the loop.
			endwhile; ?>

			</div>
			<?php
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
