<?php

// Hides the ACF optionsif the logged in user is not an admin.
function remove_acf_menu(){
	global $current_user;
	if($current_user->roles[0] != 'administrator'){
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
	}
}
add_action( 'admin_menu', 'remove_acf_menu', 100 );

// Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'General Site Options',
		'menu_title'	=> 'Options',
		'menu_slug' 	=> 'site-configuration',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}



// Load in ACF fields
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}