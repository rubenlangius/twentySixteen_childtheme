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

			<header class="page-header">
				
				<?php 
				$page = get_page_by_path('ligplaatsen-overzicht');
				$the_query = new WP_Query( 'page_id='.$page->ID );
				while ( $the_query->have_posts() ) :
					$the_query->the_post(); 
				?>

				<div class="container-fluid no-padding">
					<div class="row">
						<div class="col-sm-12">
							<h1 class="entry-title">
								<?php the_title(); ?>
							</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8 pull-left">
							<?php the_content(); ?>
						</div>
						<div class="col-sm-3 pull-right">
							<ul>
								<li class="legenda green">
								<p>Marrekrite</p>
								</li>
								<li class="legenda blue">
								<p>Ankerplaats</p>
								</li>
								<li class="legenda yellow">
								<p>Haven</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<?php endwhile;
				wp_reset_postdata();
				?>
			</header><!-- .page-header -->

		<?php if ( have_posts() ) : ?>
			<div class="entry-content">
			<div class="acf-map archivemap">
			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				$location = get_field('locatie');

			?>
			<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>" cat='<?php echo get_the_category()[0]->name; ?>'>
				<div class="hidden-xs hidden-sm hidden-md"><?php the_post_thumbnail( 'medium' ); ?></div>
				<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>				
				<p class="address"><?php echo 'Lat : ' . $location['lat'] . ', Lng : ' . $location['lng']; ?></p>
				<?php the_excerpt(); ?>	
			</div>

			<?php
			// End the loop.
			endwhile; ?>

			</div>
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
