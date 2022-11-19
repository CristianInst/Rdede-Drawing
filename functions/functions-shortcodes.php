<?php 




// function that runs when shortcode is called
function wp_itc_show_brand_logos() { 
	  
	    $html ='';

	    $args = array(
            'post_type' => 'brand',
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );


        $html .='
        <div class="homepage-brand-logos">
  

        ';

		$query = new WP_Query($args);
        if($query->have_posts()):
            while($query->have_posts()): $query->the_post();

            	$post_id = get_the_id();
            //	if($post_id != 427) {
	            	$logo = get_field('brand_logo_reverse', $post_id);
	            	if($logo['url']) {
	            		$html .= '<div><img src="'.$logo['url'].'"></div>';
	            	}
	           // }

            endwhile;
        endif;
        wp_reset_postdata();
        wp_reset_query();

        $html .='
        </div>
        ';
  
// Output needs to be return
return $html;
}
// register shortcode
add_shortcode('brand_logos', 'wp_itc_show_brand_logos');

