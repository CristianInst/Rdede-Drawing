<?php

// ======================= !ENQUEUE-SCRIPTS

//Include required scripts and styles
function setup_scripts() {

	$assets = array(
		'js' 	=> get_template_directory_uri() .'/assets/js/',
        'css' 	=> get_template_directory_uri() .'/assets/css/',
        'build' => get_template_directory_uri() .'/assets/build/min/'
	);
    
	// JS
	wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ), false, true);
    wp_enqueue_script( 'aos-js', '//unpkg.com/aos@2.3.1/dist/aos.js', array(), false, true);
	wp_enqueue_script( 'custom-js', $assets['build'] . 'main.js', array( 'jquery', 'slick-js', 'aos-js' ), false, true);
    wp_enqueue_script( 'font-awesome-kit', 'https://kit.fontawesome.com/83d4c02c61.js', [], null );

    wp_enqueue_script( 'vue-lib', '//cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js', array(), false, true);
	wp_enqueue_script( 'custom-vue', $assets['js'] . 'vue.js', array( 'vue-lib' ), false, true);
    
    
    // CSS
	wp_enqueue_style('bootstrap-styles', '//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css');
    wp_enqueue_style('slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('aos-css', '//unpkg.com/aos@2.3.1/dist/aos.css');
    
	wp_enqueue_style('custom-css', $assets['build'] . 'main.min.css');
    
    
    // Localize site directory data and nonce to javascript
    $WP = array(
        'ajax'		=> admin_url('admin-ajax.php'),
        'nonce'		=> wp_create_nonce( "ajax-nonce" ),
    );

    wp_localize_script( 'custom-js', 'WP', $WP );

}
add_action('wp_enqueue_scripts', 'setup_scripts');


// MODULARIZE (that a word?) SCRIPTS
// add_filter( 'script_loader_tag', 'module_scripts', 10, 3 );
// function module_scripts( $tag, $handle, $src ) {
//     if($handle === 'custom-vue')
//         $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
//     return $tag;
// }


// ======================= !THEME-SETUP

//Function run on theme activation
function theme_setup() {

	//Register navigation menus
    register_nav_menus(
        array(
            'header-primary' => __('Header: Primary'),
            'header-mobile' => __('Header: Mobile'),
            'footer-primary'  => __('Footer: Primary')
        )
    );

}
add_action('init', 'theme_setup', 10);






add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup(){
    // add_image_size( 'banner', 1400, 450, true );

    // Grid List
    add_image_size( 'hero', 1920, 920, true );
    add_image_size( 'listing-background', 1920, 920, false );
    add_image_size( 'listing-card', 520, 220, true );

}







// ======================= !POST TYPES

// Plural, Singular, desc, has_tax, has_single, dashicon, archive
function build_post_type(){
    $post_types = array(
        // array( 'Brands', 'Brand', '', false, false, 'networking', false ),
        // array( 'Careers', 'Careers', '', true, true, 'businessperson', false ),
        // array( 'Team', 'Team', '', true, true, 'groups', false ),
    );
    foreach($post_types as $pt)
        create_post_type($pt);
}
add_action( 'init', 'build_post_type', 0 );


function create_post_type($args){
    $i = 0;
    $defaultKey = array(
        'plural' => '',
        'singular' => '',
        'desc' => '',
        'has_tax' => false,
        'has_single' => false,
        'dashicon' => 'buddicons-topics',
        'archive' => true,
        'label' => $args[0]
    );
    $defaultKeys = array_keys($defaultKey);
    $propArr = array();
    foreach($defaultKey as $k => $v){
        $propArr[$k] = count($args) > $i ? $args[$i] : $v;
        $i++;
    }

    $register_name = strtolower(str_replace(' ' , '-', $propArr['singular']));
    $register_plural = strtolower(str_replace(' ' , '-', $propArr['plural']));

    $labels = array(
        'name'                => $propArr['plural'],
        'singular_name'       => $propArr['singular'],
        'menu_name'           => $propArr['label'],
        'parent_item_colon'   => $propArr['plural'],
        'all_items'           => 'All '.$propArr['label'],
        'view_item'           => 'View '.$propArr['singular'],
        'add_new_item'        => 'Add New '. $propArr['singular'],
        'edit_item'           => 'Edit '.$propArr['singular'],
        'update_item'         => 'Update '.$propArr['singular'],
        'search_items'        => 'Search '.$propArr['plural'],
    );
    $args = array(
        'label'               => $register_name,
        'description'         => $propArr['desc'],
        'labels'              => $labels,
        'menu_position'       => 40,
        'menu_icon'           => 'dashicons-'.$propArr['dashicon'],
        'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions', 'custom-fields', 'page-attributes', 'excerpt' ),
        'public'			  => true,
        'has_archive'         => false,
        // 'show_in_rest' => true,
    );
    register_post_type( $register_name, $args );


    // TAXONOMIES
    if($propArr['has_tax']){
        $teams_cats = array(
            // Hierarchical taxonomy (like categories)
            'hierarchical' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels'       => array(
                'name'              => _x( $propArr['singular'].' Categories', 'taxonomy general name' ),
                'singular_name'     => _x( $propArr['singular'].' Category', 'taxonomy singular name' ),
            ),
            // Control the slugs used for this taxonomy
            'rewrite'      => array(
            'slug'         => $register_name.'-categories', // This controls the base slug that will display before each term
            'with_front'   => $propArr['has_single'], // Don't display the category base before "/locations/"
            'hierarchical' => true, // This will allow URL's like "/locations/boston/cambridge/"
            'has_archive'   => false,
            ),
        );
        register_taxonomy( $register_plural.'-categories', $register_name, $teams_cats );
    }

}



// Sidebar registration
// function theme_sidebars(){
//     register_sidebar(array(
//         'id' => __( 'standard-sidebar' ),
//         'name' => __( 'Standard Sidebar', 'this_theme' )
//     ));
// }
// add_action( 'widgets_init', 'theme_sidebars' );



// Allow SVG and WebP uploads in media library
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');




// ======================= !MENU WALKER


class MainMenuPrimary extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0){
       // if($depth === 0)
		    $output .= '<li id="'.$item->ID.'" class="'.implode(' ', $item->classes).'"><a href="'.$item->url.'" class="menu-link">'. $item->title.'</a>';
	}
}

class FooterMenuWrap extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0){
		$output .= '<li><a href="'.$item->url.'">'. $item->title.'</a>';
	}
}

class VueMenuWrap extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0){
        $wChildren = false;
		if( in_array('menu-item-has-children', $item->classes) )
            $wChildren = true;
            
		$output .= '<li '.($wChildren && $depth == 0 ? 'class="menu-item-has-children"' : '') .' v-bind:class="{ open: '.$item->ID.' == mobileLevel }">
            <a href="'.$item->url .'">'.$item->title.'</a>'. ($wChildren && $depth == 0 ? '<i class="fa fa-chevron-down" @click="updateLevel('.$item->ID.')"></i>' : '');
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu level-".$depth."\">\n";

    }
    
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

}

// =======================



// Allow post thumbnails
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo', array(
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
) );
add_theme_support( 'editor-styles' );
add_post_type_support( 'page', 'excerpt' );
add_editor_style( 'assets/css/editor.css' );


add_action( 'template_redirect', 'remove_wpseo' );

/**
 * Removes output from Yoast SEO on the frontend for a specific post, page or custom post type.
 */
function remove_wpseo() {
    if ( is_singular('careers') ) {
        $front_end = YoastSEO()->classes->get( Yoast\WP\SEO\Integrations\Front_End_Integration::class );

        remove_action( 'wpseo_head', [ $front_end, 'present_head' ], -9999 );
    }
}




function pine_remove_yoast_breadcrumb_link($link_output , $link)
{

    if($link['text'] == 'Team') {
      $link_output = '<a href="/who-we-are/executive-team/">Executive Team</a>';
    }

    // if($link['text'] == 'Careers') {
    //   $link_output = '<a href="/who-we-are/executive-team/">Careers</a>';
    // }

    return $link_output;
}
add_filter('wpseo_breadcrumb_single_link' ,'pine_remove_yoast_breadcrumb_link', 10 ,2);




// add_filter( 'wpseo_breadcrumb_links', 'yoast_seo_breadcrumb_news' );
// function yoast_seo_breadcrumb_news( $links ) { 
//     global $post;    
//     if ((is_singular('post')) || (is_archive())) {
//         $breadcrumbs[] = array(
//             array(
//                 'url' => site_url( '/about' ),
//                 'text' => 'About Us'
//             ),
//             array(
//                 'url' => site_url( '/about/news' ),
//                 'text' => 'News'
//             )
//         );
//         foreach ($breadcrumbs as $breadcrumb) {
//             array_splice($links, 1, -2, $breadcrumb);
//         }
//     }
// return $links;
// }