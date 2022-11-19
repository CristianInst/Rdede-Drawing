<?php
    $backgroundImage = get_field('background_image');
    $content = get_field('content');
    $cta_array = get_field('cta')['items'] ?: array();

   // echo print_r($backgroundImage);
?>
<section id='<?php echo $block['id']; ?>' class='block--hero' <?php echo ($backgroundImage ? 'style="background-image: url('.$backgroundImage['url'].');"' : ''); ?>>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-6">
                <?php echo $content; ?>
                <?php
                    if(count($cta_array) > 0){
                        echo '<div class="cta--holder">';
                        foreach($cta_array as $cta)
                            includeComponent('cta', true, array( 'text' => $cta['cta_text'], 'url' => $cta['cta_url'], 'icon' => $cta['cta_icon'] ));
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>