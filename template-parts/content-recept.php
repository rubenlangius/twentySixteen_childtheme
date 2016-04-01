<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
 	
 	<?php twentysixteen_post_thumbnail(); ?>

	<div class="entry-content">
		
		<?php
			$fields = get_field_objects();
			if( $fields ) : ?>
			<div class="container-fluid">
				<div class="row specscontainer">
					<div class="col-xs-12 col-sm-6">
						<ul class='specs'>
							<li>Ingrediënten</li>
							<?php echo get_field( "ingredienten" );?>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-6">
						<ul class='specs'>
							<li>Aantal personen</li>
							<?php echo get_field( "aantal_personen" );?>
							<li>Bereidingstijd</li>
							<?php echo get_field( "bereidingstijd" ) . ' minuten';?>
							<li>Benodigdheden</li>
							<?php echo get_field( "benodigdheden" );?>
						</ul>
					</div>
				</div>
			</div>
		<?php endif; ?>

		

			<?php the_content(); ?>

			<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
