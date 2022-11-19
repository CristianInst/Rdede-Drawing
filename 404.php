<?php get_header(); ?>

<section class="page-not-found">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 offset-0 offset-md-2 offset-lg-3 text-center">
                <a href="<?php echo get_home_url(); ?>"><?php echo (has_custom_logo() ? the_custom_logo() : ''); ?></a>
                <h1>Page not found</h1>
                <p>Unfortunately this page has either moved or does not exist.</p>
                <a href="<?php echo get_home_url(); ?>" class="component--cta has-icon">Home<i class="fa-solid fa-arrow-right-long"></i></a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>