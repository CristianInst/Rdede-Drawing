<?php get_header(); ?>

<?php
    $shareMe = true;
    $subNav = array();
    $title = get_field('title', get_the_id()) ?: get_the_title();

    $linkedinUrl = get_field('linkedin_url', get_the_id());    
    $jobTitle = get_field('job_title', get_the_id());


    $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'large' );



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


<section id="single-team" class="single-team-block">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-3 offset-md-1">
                   <span class="d-block d-lg-none top-back goBack" onClick="window.history.back()"><i class="fa-solid fa-arrow-left-long"></i>Back</span>
              <div class='component--listing-card-team single-block-mobile' data-aos="fade" data-aos-delay="<?php echo $aosDelay; ?>">
                    <div class="component--image" style="background-image: url(<?php echo $image; ?>);"></div>
                    <div class="component--info component--single-card">
                        
                    </div>
                </div>

            </div>

       
            <div class="col-12 col-md-6 offset-md-1" style="position:relative;">
                <span class="d-none d-lg-block goBack" onClick="window.history.back()"><i class="fa-solid fa-arrow-left-long"></i>Back</span>
               <h1><?php echo  $title; ?></h1>
                <p class="job-title"><?php echo $jobTitle; ?>
                     <?php if($linkedinUrl): ?>
                                <a href="<?php echo $linkedinUrl; ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin linked"></i></a>
                            <?php endif; ?>
                </p>
               <? the_content(); ?>
            </div>


        </div>
    </div>


</section>

<?php get_footer(); ?>