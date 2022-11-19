<?php get_header(); ?>

<?php
    if(get_field('brand'))
        $brandID = property_exists(get_field('brand'), 'ID')? get_field('brand')->ID : 0;
    else
        $brandID = 0;
    $theBrand = buildBrand($brandID);

    $shareMe = true;
    $subNav = array();
    $title = get_field('title', get_the_id()) ?: get_the_title();
?>

<section class='block--breadcrumbs'>
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-12 col-sm-6">
                <?php
                    if ( function_exists('yoast_breadcrumb') )
                        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                ?>
            </div>
            <div class="col-12 col-sm-6 d-flex justify-content-end align-items-center">
                <?php
                    if(count($subNav) > 0){
                        echo '<ul class="breadcrumb-menu">';
                        foreach($subNav as $nav_item){
                            echo '<li><a href="'. get_permalink($nav_item['item']->ID) .'">'.$nav_item['item']->post_title.'</a></li>';
                        }
                        echo '</ul>';
                    }

                    if($shareMe)
                        echo '<i class="fa-solid fa-share-nodes"></i>';
                ?>
            </div>
        </div>
    </div>
</section>

<section class="the--role">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-6 position-relative">
                <span class="goBack" onClick="window.history.back()"><i class="fa-solid fa-arrow-left-long"></i>Back</span>
                <?php 
                    includeComponent('brand-colophon', true, array( 'id' => $brandID ));
                    echo '<h1>'. $title .'</h1>';
                    the_field('content');
                    the_field('repeat_content', 'options');
                    
                    if(get_field('application_form', 'options'))
                        echo '<a href="#application-form" class="button fill c--ocean-blue has-icon">Apply<i class="fas fa-arrow-right-long"></i></a>';
                ?>
            </div>
            <div class="d-none d-xl-block col-5 offset-1">
                <?php if($brandID): ?>
                <aside style="background-color: <?php echo $theBrand['brand_color']; ?>; color: <?php echo $theBrand['font_color']; ?>;">
                    <div class="brand--image"><img src="<?php echo $theBrand['featured_image'][0]; ?>" /></div>
                    <div class="brand--content">
                        <h3><?php echo $theBrand['title']; ?></h3>
                        <?php echo $theBrand['content']; ?>
                    </div>
                </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
        if(get_field('application_form', 'options'))
            includeComponent('application-form', true, array( 'form' => get_field('application_form', 'options') ));
    ?>

</section>

<?php includeComponent('related-careers', true); ?>

<?php get_footer(); ?>