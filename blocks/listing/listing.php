<?php
    $backgroundImage = get_field('background_image') ? get_field('background_image')['sizes']['hero'] : false;
    $content = get_field('content');
    $items = get_field('items');

    // DB: Hack for changing our values to col-6/2 per row
    $grid_override = '';
    if($block['id'] == 'block_6282211cfe07d') {
        $grid_override ='grid-value-override';
    }


?>
<section 
    id='<?php echo $block['id']; ?>' class='block--listing' 
    <?php if($backgroundImage): ?>
    style="background-image: url(<?php echo $backgroundImage; ?>"
    <?php endif; ?>
>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="listing--content" >
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="listing--wrapper <?php echo $grid_override; ?>" >
                <?php
                    foreach($items as $item){
                        $item['aos-delay'] = $c * $aosStandard;
                        includeComponent('listing-card', true, array( 'item' => $item ));
                        $c++;
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</section>