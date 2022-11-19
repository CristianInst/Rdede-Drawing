<?php
    if(isset($form)):
?>
<div class='component--application-form'>
    <div class="application-form--content">
        <i class="fas fa-times-circle"></i>
        <?php echo do_shortcode($form); ?>
    </div>
</div>
<?php endif; ?>