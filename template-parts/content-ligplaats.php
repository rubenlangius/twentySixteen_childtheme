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
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
 	<?php 
 	$location = get_field('locatie');
	if( !empty($location) ):
	?>
	<div class="acf-map">
		<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>" cat='<?php echo get_the_category()[0]->name; ?>'></div>
	</div>
	<?php endif; ?>

	<div class="entry-content">
		

		<?php
			$fields = get_field_objects();
			if( $fields ) : ?>
			<div class="container-fluid">
				<div class="row specscontainer">
						<?php	
						unset($fields['locatie']);
						$len = count($fields);
						$firsthalf = array_slice($fields, 0, $len / 2);
						$secondhalf = array_slice($fields, $len / 2);
						echo '<div class="col-xs-6">';
						echo "<ul class='specs'>";
						foreach( $firsthalf as $field_name => $field )
						{
							echo '<li>';
								echo '<h7>' . $field['label'] . ' : ' . $field['value'] .'</h7>';
							echo '</li>';
						}
						echo "</ul>";
						echo '</div>
					<div class="col-xs-6">';
						echo "<ul class='specs'>";
						foreach( $secondhalf as $field_name => $field )
						{
							echo '<li>';
								echo '<h7>' . $field['label'] . ' : ' . $field['value'] .'</h7>';
							echo '</li>';
						}
						echo "</ul>";
						?>
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
