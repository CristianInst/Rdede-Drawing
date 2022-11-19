<?php



// ======================= !WP ACF BLOCKS

function theme_acf_init() {
    if(function_exists('acf_register_block')){
        //[!GULP]
		generateBlock( 'Media', 'media', '', 'editor-video' );
		generateBlock( 'Listing', 'listing', '', 'list-view' );
		generateBlock( 'Content', 'content', '', 'align-left' );
		generateBlock( 'Breadcrumbs', 'breadcrumbs', '', 'ellipsis' );
		generateBlock( 'Hero', 'hero', '', 'slides' );
		generateBlock( 'Formal', 'formal', '', 'media-document' );
    }
}

function theme_block_category( $categories, $post ) {
    $theme = wp_get_theme();
    return array_merge(
        $categories,
        array(
            array(
                'slug' => $theme->get('Name'),
                'title' => __( $theme->get('Name'), $theme->get('Name') ),
            ),
        )
    );
}
add_filter( 'block_categories', 'theme_block_category', 10, 2);
function generateBlock( $title, $slug, $desc, $icon = 'id', $keywords = array() ){
    $theme = wp_get_theme();
    $name = $theme->get('Name');
    return acf_register_block(array(
        'name'				=> $slug,
        'title'				=> __($title),
        'description'		=> __($desc),
        'render_callback'	=> 'theme_acf_block_render_callback',
        'category'			=> $name,
        'icon'				=> ($icon ?: 'topics'),
        'keywords'			=> $keywords,
    ));
}

function theme_acf_block_render_callback( $block ) {
    
    $slug = str_replace('acf/', '', $block['name']);
    
    if(file_exists(get_theme_file_path("/blocks/{$slug}/{$slug}.php")))
        include( get_theme_file_path("/blocks/{$slug}/{$slug}.php") );
    
}

add_action('acf/init', 'theme_acf_init');


// Default blocks
function myplugin_register_template() {
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array(
        // array( 'acf/banners' ),
        // array( 'acf/find-a-tutor' ),
    );
}
add_action( 'init', 'myplugin_register_template' );