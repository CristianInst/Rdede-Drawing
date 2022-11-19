<?php

// Remove dashboard widgets
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


	// Remove WP header guff
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

  // Remove WP script guff
  function remove_wpf_styles(){
	wp_deregister_script('grid');
	wp_deregister_script('reset');
	wp_deregister_script('default');
	wp_deregister_script('master');
  } 
  add_action('wp_print_styles', 'remove_wpf_styles', 100);


  // Remove more WP guff
  function unregister_javascript(){
	wp_deregister_script('superfish');
	wp_deregister_script('superfish-args');
	wp_deregister_script('comment-reply');
  }
  add_action('wp_enqueue_scripts', 'unregister_javascript');


  // Remove the comments side of the site
  function remove_menus(){
	remove_menu_page('edit-comments.php');
	remove_menu_page('link-manager.php');
  }
  add_action('admin_menu', 'remove_menus');

/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    // add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    // add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
   }
   add_action( 'init', 'disable_emojis' );

  // Change the Admin login logo
function admin_logo(){
	$logo = 'https://authenticity.digital/assets/img/black-authenticity.png';
	echo '<style>';
		echo '
		html, body {
			margin: 0;
			padding: 0;
			font-size: 10px;
			line-height: 10px;
		}
		.login #nav a, .login #backtoblog a {
			color: #000;
			user-select: none;
			transition: opacity 0.35s ease;
			opacity: 1;
		}
		.login #nav a:hover, .login #backtoblog a:hover {
			opacity: 0.85;
			color: #000;
		}
		.login h1 a {
			background: no-repeat url('. $logo .') center / contain !important;
			height: 15rem;
			width: 27.5rem;
			margin: 0 auto;	
		}
		.login, #wp-auth-check {
			background-color: #FFF;
		}';
	echo '</style>';
}
add_action('login_head', 'admin_logo');


// Change the admin login URL
function admin_login_url(){
return home_url();
}
add_action('login_headerurl', 'admin_login_url');


// Change the Admin login logo title
function my_login_logo_url_title() {
	return get_bloginfo('name');
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );



// Admin footer modification
function remove_footer_admin(){
    echo '<span id="footer-thankyou">powered by <a href="https://authenticity.digital" target="_blank">Authenticity</a></span>';
}

add_filter('admin_footer_text', 'remove_footer_admin');






// AUTO UPDATE PLUGINS
// Ignore ACF Pro
function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
add_filter( 'auto_update_core', '__return_true' );
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'auto_update_translation', '__return_true' );


add_action('after_setup_theme', function() {

    // remove SVG and global styles
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
  
    // remove wp_footer actions which add's global inline styles
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
  
    // remove render_block filters which adding unnecessary stuff
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block', 'wp_restore_group_inner_container');
    remove_filter('render_block', 'wp_render_layout_support_flag');
});




// WPENGINE - determine between production and dev environments
function site_environment(){
    if(strpos($_SERVER['SERVER_NAME'], 'wpengine') !== false || strpos($_SERVER['SERVER_NAME'], '.test') !== false)
        return 'dev';
    else
        return 'prd';
}
define('SITE_ENV', site_environment());