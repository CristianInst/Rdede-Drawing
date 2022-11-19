<?php
    $cookiePage = get_field('cookie_policy', 'options');
    if($cookiePage):
?>
<div id="cookie" class="pending">
    <p>By using our site, you consent<br />to cookies. <a href="<?php echo get_permalink($cookiePage); ?>">Learn more</a></p>
    <button type="button" class="has-icon outline c--ocean-blue"><i class="fas fa-times"></i></a>
</div>
<?php endif; ?>