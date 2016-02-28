<?php

// Load the custom css file

function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/bootstrap/bootstrap.css');
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// add a new customizer function for uploading a logo

function childtheme_customize_register( $wp_customize )
{
   	$wp_customize->add_section( 'childtheme_logo_section' , array(
    'title'       => __( 'Logo', 'childtheme' ),
    'priority'    => 30,
    'description' => 'Upload a logo which will be placed left of the default site name and description in the header',
	) );
 
 	$wp_customize->add_setting( 'childtheme_logo' );

 	$wp_customize->add_control( 
 		new WP_Customize_Image_Control( 
 			$wp_customize, 'childtheme_logo', array(
		    'label'    => __( 'Logo', 'childtheme' ),
		    'section'  => 'childtheme_logo_section',
		    'settings' => 'childtheme_logo',
			) 
		) 
 	);

}
add_action( 'customize_register', 'childtheme_customize_register' );

// change the excerpt function from the parent theme

function twentysixteen_excerpt( $class = 'excerpt' ) {
    $class = esc_attr( $class );

    if ( has_excerpt() || is_search() ) : ?>
        <div class="<?php echo $class; ?>">
            <?php the_excerpt(); ?>
        </div><!-- .<?php echo $class; ?> -->
    <?php endif;
}

// change the thumbnail function

function twentysixteen_post_thumbnail() {
    if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
        return;
    }

    if ( is_singular() ) :
    ?>

    <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
    </div><!-- .post-thumbnail -->

    <?php else : ?>

    <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
        <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
    </a>

    <?php endif; // End is_singular()
}

add_image_size( 'loop-thumb', 600, 600 ); 


?>