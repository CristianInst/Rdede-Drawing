<?php

require_once('functions/functions-helpers.php'); 		// PHP/Wordpress Utility Functions
require_once('functions/functions-admin.php'); 			// Modify Wordpress Admin UI
require_once('functions/functions-email.php'); 			// Contact Form API
require_once('functions/functions-theme.php'); 			// Theme Setup & Config
require_once('functions/functions-blocks.php');     // Theme Blocks (requires ACF)
// require_once('functions/functions-widgets.php');     // NEW - Widgets
require_once('functions/functions-shortcodes.php');     // NEW - Shortcodes

// ACF Options
require_once get_template_directory() . '/functions/acf-options.php';

// Activate WordPress Maintenance Mode
add_action( 'wp_loaded', function() 
{
    global $pagenow;

    // - - - - - - - - - - - - - - - - - - - - - - 
    // Turn on/off you Maintenance Mode (true/false)

    // - - - - - - - - - - - - - - - - - - - - - - 

    if(
        defined( 'IN_MAINTENANCE' )
        && IN_MAINTENANCE
        && $pagenow !== 'wp-login.php'
        && ! is_user_logged_in()
    ) {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header( 'Content-Type: text/html; charset=utf-8' );
        if ( file_exists( get_template_directory() . '/maintenance.php' ) ) {
            require_once( get_template_directory() . '/maintenance.php' );
        }
        die();
    }
});