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
					<div class="col-xs-6">
						<ul class='specs'>
							<li>Beoordeling</li>
							<?php 
							$field = get_field_object( "rating" );
							if ($field['value']) : echo $field['label']." : ".$field['value']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "opmerking" );
							if ($field['value']) : echo $field['value']."<br>"; endif;
							?>
							<li>Haven weetjes</li>
							<?php 
							$field = get_field_object( "prijs" );
							if ($field['value']) : echo $field['label']." : ".$field['value']." euro"."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "ligplaatsen" );
							if ($field['value']) : echo $field['value']." ".$field['name']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "diepte" );
							if ($field['value']) : echo $field['label']." : ".$field['value']." meter"."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "externe_url" );
							if ($field['value']) : echo $field['value']."<br>"; endif;
							?>
						</ul>
					</div>
					<div class="col-xs-6">
						<ul class='specs'>
							<li>Voorzieningen</li>
							<?php 
							$field = get_field_object( "wc" );
							if ($field['value']) : echo $field['label']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "douche" );
							if ($field['value']) : echo $field['label']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "electra" );
							if ($field['value']) : echo $field['label']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "water" );
							if ($field['value']) : echo $field['label']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "vuilwater" );
							if ($field['value']) : echo $field['label']."<br>"; endif;
							?>
							<?php 
							$field = get_field_object( "voorzieningen_opmerking" );
							if ($field['value']) : echo $field['value']."<br>"; endif;
							?>
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
