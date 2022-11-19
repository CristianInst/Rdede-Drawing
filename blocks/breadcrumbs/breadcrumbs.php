<?php
    $shareMe = get_field('shareable');
    $subNav = get_field('sub_nav') ?: array();
?>
<section id='<?php echo $block['id']; ?>' class='block--breadcrumbs'>
    <div class="container-fluid">
        <div class="row d-flex align-items-center">

        <?php if(!is_front_page()) { ?>
            <div class="col-12 col-sm-6">
                <?php
                    if ( function_exists('yoast_breadcrumb') )
                        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                ?>
            </div>

        <?php  } else { ?>

             <div class="col-12 col-sm-6">
                <p id="breadcrumbs">&nbsp;</p>
             </div>
             <div class="col-12 col-sm-6 d-flex justify-content-end align-items-center">
            </div>

        <?php } ?>

        </div>
    </div>
</section>