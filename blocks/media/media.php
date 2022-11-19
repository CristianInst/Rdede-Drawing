<?php
    $type = get_field('type');
    $video = get_field('video') ?: false;
    $image = get_field('image') ?: false;
?>
<section id='<?php echo $block['id']; ?>' class='block--media'>
    <div class="media--container" data-type="<?php echo $type; ?>" data-aos="fade">
        <?php if($type === 'video'): ?>
            <video muted loop>
                <source src="<?php echo $video['url']; ?>" type="<?php echo $video['mime_type']; ?>">
            </video>
            <span></span>
        <?php else: ?>
            <div class="media--image" style="background-image: url(<?php echo $image['url']; ?>);"></div>
        <?php endif; ?>
    </div>
</section>

