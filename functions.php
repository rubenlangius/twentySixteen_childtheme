<?php

// Load the custom css file

function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '3', true );
    wp_enqueue_script( 'google-map-init', get_stylesheet_directory_uri() . '/js/google-maps.js', array('google-map', 'jquery'), '0.1', true );

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

    if ( (is_category() || is_tag() || is_home()) && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'ligplaats', 'recept', 'diy' ) );
    return $query;
}

// Register Custom Ligplaats Post Type
function ligplaats_post_type() {

    $labels = array(
        'name'                  => _x( 'Ligplaatsen', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Ligplaats', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Ligplaatsen', 'text_domain' ),
        'name_admin_bar'        => __( 'Ligplaatsen', 'text_domain' ),
        'archives'              => __( 'Ligplaatsen Archief', 'text_domain' ),
        'parent_item_colon'     => __( 'Hoofd ligplaats:', 'text_domain' ),
        'all_items'             => __( 'Alle ligplaatsen', 'text_domain' ),
        'add_new_item'          => __( 'Nieuwe ligplaats', 'text_domain' ),
        'add_new'               => __( 'Voeg toe', 'text_domain' ),
        'new_item'              => __( 'Nieuwe ligplaats', 'text_domain' ),
        'edit_item'             => __( 'Edit ligplaats', 'text_domain' ),
        'update_item'           => __( 'Update ligplaats', 'text_domain' ),
        'view_item'             => __( 'Bekijk ligplaats', 'text_domain' ),
        'search_items'          => __( 'Zoek in ligplaatsen', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into ligplaats', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this ligplaats', 'text_domain' ),
        'items_list'            => __( 'Ligplaatsen lijst', 'text_domain' ),
        'items_list_navigation' => __( 'Ligplaatsen lijst navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter ligplaatsen lijst', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Ligplaats', 'text_domain' ),
        'description'           => __( 'custom post type speciaal voor ligplaatsen.', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => true,
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
        'capability_type'       => 'post',
    );
    register_post_type( 'ligplaats', $args );

}
add_action( 'init', 'ligplaats_post_type', 0 );

// Register Custom Recept Post Type
function recept_post_type() {

    $labels = array(
        'name'                  => _x( 'Recepten', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Recept', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Recepten', 'text_domain' ),
        'name_admin_bar'        => __( 'Recepten', 'text_domain' ),
        'archives'              => __( 'Recepten Archief', 'text_domain' ),
        'parent_item_colon'     => __( 'Hoofd recept:', 'text_domain' ),
        'all_items'             => __( 'Alle recepten', 'text_domain' ),
        'add_new_item'          => __( 'Nieuw recept', 'text_domain' ),
        'add_new'               => __( 'Voeg toe', 'text_domain' ),
        'new_item'              => __( 'Nieuw recept', 'text_domain' ),
        'edit_item'             => __( 'Edit recept', 'text_domain' ),
        'update_item'           => __( 'Update recept', 'text_domain' ),
        'view_item'             => __( 'Bekijk recept', 'text_domain' ),
        'search_items'          => __( 'Zoek in recepten', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into recept', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this recept', 'text_domain' ),
        'items_list'            => __( 'Recepten lijst', 'text_domain' ),
        'items_list_navigation' => __( 'Recepten lijst navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Recepten lijst', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Recept', 'text_domain' ),
        'description'           => __( 'custom post type speciaal voor recepten.', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => true,
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
        'capability_type'       => 'post',
    );
    register_post_type( 'recept', $args );

}
add_action( 'init', 'recept_post_type', 0 );

// Register Custom Recept Post Type
function diy_post_type() {

    $labels = array(
        'name'                  => _x( 'Diys', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Diy', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Diys', 'text_domain' ),
        'name_admin_bar'        => __( 'Diys', 'text_domain' ),
        'archives'              => __( 'Diys Archief', 'text_domain' ),
        'parent_item_colon'     => __( 'Hoofd diy:', 'text_domain' ),
        'all_items'             => __( 'Alle diys', 'text_domain' ),
        'add_new_item'          => __( 'Nieuw diy', 'text_domain' ),
        'add_new'               => __( 'Voeg toe', 'text_domain' ),
        'new_item'              => __( 'Nieuw diy', 'text_domain' ),
        'edit_item'             => __( 'Edit diy', 'text_domain' ),
        'update_item'           => __( 'Update diy', 'text_domain' ),
        'view_item'             => __( 'Bekijk diy', 'text_domain' ),
        'search_items'          => __( 'Zoek in diys', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into diy', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this diy', 'text_domain' ),
        'items_list'            => __( 'Diys lijst', 'text_domain' ),
        'items_list_navigation' => __( 'Diys lijst navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter diys lijst', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Diy', 'text_domain' ),
        'description'           => __( 'custom post type speciaal voor diys.', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => true,
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
        'capability_type'       => 'post',
    );
    register_post_type( 'diy', $args );

}
add_action( 'init', 'diy_post_type', 0 );


function twentysixteen_entry_meta() {
    if ( 'post' === get_post_type() || 'ligplaats' === get_post_type() || 'recept' === get_post_type() || 'diy' === get_post_type() ) {
        $author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
        printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
            get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
            _x( 'Author', 'Used before post author name.', 'twentysixteen' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author()
        );
    }

    if ( in_array( get_post_type(), array( 'post', 'attachment', 'ligplaats', 'recept', 'diy' ) ) ) {
        twentysixteen_entry_date();
    }

    $format = get_post_format();
    if ( current_theme_supports( 'post-formats', $format ) ) {
        printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
            sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
            esc_url( get_post_format_link( $format ) ),
            get_post_format_string( $format )
        );
    }

    if ( 'post' === get_post_type() || 'ligplaats' === get_post_type() || 'recept' === get_post_type() || 'diy' === get_post_type() ) {
        twentysixteen_entry_taxonomies();
    }

    if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentysixteen' ), get_the_title() ) );
        echo '</span>';
    }
}

function list_child_pages() { 

    global $post;
     
    //query subpages
    $args = array(
        'post_parent' => $post->ID,
        'post_type' => 'page'
    );
    $subpages = new WP_query($args);
     
    // create output
    if ($subpages->have_posts()) :
        $output = '<ul>';
        while ($subpages->have_posts()) : $subpages->the_post();
            $output .= '<li><strong><a href="'.get_permalink().'">'.get_the_title().'</a></strong>
                        <p>'.get_the_excerpt();
        endwhile;
        $output .= '</ul>';
    else :
        $output = '<p>No subpages found.</p>';
    endif;
     
    // reset the query
    wp_reset_postdata();
     
    // return something
    return $output;


}

add_shortcode('list_child_pages', 'list_child_pages');

?>