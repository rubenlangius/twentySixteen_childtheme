<?php

// Load the custom css file

function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css');
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

// add a custom excerpt filter so manually generated excerpts also have a 'read more' link

function manual_excerpt_more( $excerpt ) {
    $excerpt_more = '';
    if( has_excerpt() ) {
        $link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
        esc_url( get_permalink( get_the_ID() ) ),
        /* translators: %s: Name of current post */
        sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ), get_the_title( get_the_ID() ) )
    );
    }
    return $excerpt . '&hellip; ' . $link;
}
add_filter( 'get_the_excerpt', 'manual_excerpt_more' );

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

// custom post formats list
add_action( 'after_setup_theme', 'childtheme_formats', 11 );
function childtheme_formats(){
     add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'status' ) );
}

// display custom posts in the main loop

add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'havens' ) );

    return $query;
}

// Register Custom Post Type
function custom_post_type() {

    $labels = array(
        'name'                  => _x( 'Havens', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Haven', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Havens', 'text_domain' ),
        'name_admin_bar'        => __( 'Havens', 'text_domain' ),
        'archives'              => __( 'Havens Archief', 'text_domain' ),
        'parent_item_colon'     => __( 'Hoofd haven:', 'text_domain' ),
        'all_items'             => __( 'Alle Havens', 'text_domain' ),
        'add_new_item'          => __( 'Nieuwe Haven', 'text_domain' ),
        'add_new'               => __( 'Voeg toe', 'text_domain' ),
        'new_item'              => __( 'Nieuwe Haven', 'text_domain' ),
        'edit_item'             => __( 'Edit Haven', 'text_domain' ),
        'update_item'           => __( 'Update Haven', 'text_domain' ),
        'view_item'             => __( 'Bekijk Haven', 'text_domain' ),
        'search_items'          => __( 'Zoek in Havens', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Haven', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this haven', 'text_domain' ),
        'items_list'            => __( 'Haven lijst', 'text_domain' ),
        'items_list_navigation' => __( 'Haven lijst navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter haven lijst', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Haven', 'text_domain' ),
        'description'           => __( 'custom post type speciaal voor havens.', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-clipboard',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'havens', $args );

}
add_action( 'init', 'custom_post_type', 0 );

?>