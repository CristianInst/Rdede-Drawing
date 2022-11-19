<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="msapplication-TileColor" content="#072a3a" />
        <link rel="icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/assets/img/favicon.ico">
     
        <!-- GOOGLE FONTS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;900&display=swap" rel="stylesheet">

        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=62559ca480366d0019fc1aff&product=sop' async='async'></script>
        
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

        <header id="app-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        
                        <div class="logo">
                           <img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content\uploads\2022\Logo\wismettac-logo.jpg" alt="<?php echo get_bloginfo('name'); ?>">
                        </div>

                    </div>
                    <div class="col-6 col-lg-10 col-xl-10 d-flex justify-content-end align-self-center">
                        <?php wp_nav_menu(array('theme_location' => 'header-primary', 'walker' => new MainMenuPrimary())); ?>
                        <div class="mobile-menu-toggle">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main id="app">