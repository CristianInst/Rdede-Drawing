<?php
    [
        'title' => $title,
        'content' => $content,
        'image' => $image,
        'icon' => $icon,
        'aos-delay' => $aosDelay
    ] = $item;
    $cta_array = $item['cta']['items'] ?: array();
?>

<!-- data-aos="fade-up" data-aos-delay="<?php echo $aosDelay; ?>" -->

<div class='component--listing-card'>
    <?php 



    //$image["sizes"]["listing-card"] 

        echo ($image ? '<div class="card--image" style="background-image: url('. $image["url"] .');"></div>' : '');

        echo '<div class="card--content">';
        echo ($icon && !$image ? '<img src="'. $icon['url'] .'" />' : '');
        echo ($title ? '<h3>'.$title.'</h3>' : '');
        echo ($content ? '<p>'.$content.'</p>' : '');
        
        if(count($cta_array) > 0){
            echo '<div class="cta--holder">';
            foreach($cta_array as $cta){
                includeComponent('cta', true, array( 'text' => $cta['cta_text'], 'url' => $cta['cta_url'], 'icon' => $cta['cta_icon'] ));
            }
            echo '</div>';
        }
        echo '</div>';
    ?>
</div>